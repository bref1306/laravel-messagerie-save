<?php 

namespace App\Repository;


use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;



class ConversationRepository {

    /**
     * @var User
     */
    private $user;
    /**
     * @var Message
     */
    private $message;

    public function __construct (User $user, Message $message) {
        $this->user = $user;
        $this->message = $message;
    }

    public function getConversations (int $userId) {
        $conversations = $this->user->newQuery()
        ->select('name', 'id')
        ->where('id', '!=', $userId)
        ->get();
        $unread = $this->unreadCount($userId);

        return $conversations;
    }
    public function createMessage(string $content, int $from, int $to) {
        return $this->message->newQuery()->create([
            'content' => $content,
            'from_id' => $from,
            'to_id' => $to,
            'created_at' => Carbon::now()
        ]);
  
    }

    public function getMessagesFor(int $from, int $to): Builder {
        return $this->message->newQuery()
        ->WhereRaw("(( from_id = $from AND to_id = $to) OR ( from_id = $to AND to_id = $from))")
        ->orderBy('created_at', 'DESC')
        ->with([
            'from'=> function($query) { return $query->select('name', 'id');}
        ]);
    }
    /**
     * Récupère le nombre de messages non lus
     */
    public function unreadCount(int $userId){
        return $this->message->newQuery()
        ->where('to_id', $userId)
        ->groupBy('from_id')
        ->selectRaw('from_id, COUNT(id) as count') /*select RAw car n'injecte rien*/
        ->whereRaw('read_at is NULL')
        ->get()
        ->pluck('count', 'from_id');
    }
    /*
        Marque tous les messages de cet utilisateur en lu
    */
    public function readAllFrom(int $from, int $to) {
        $this->message->where('from_id', $from)->where('to_id', $to)->update(['read_at' => Carbon::now()]);
    }

    public function RemoveMessage(int $userId){
        DB::table('messages')->where('id', $userId)->delete();
    }
}