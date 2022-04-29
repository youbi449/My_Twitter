<?php

include('connexionbdd.class.php');


class Messagerie
{

    protected $connexion;
    protected $bdd;
    protected $message;
    protected $from;
    protected $to;


    public function __construct()
    {
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getUser()
    {
        // selectionne les utilisateurs la base 
        $query = $this->bdd->prepare('SELECT * FROM users');
        $query->execute(); 
        $echo = "";

        while ($result = $query->fetch()) {
            $echo .= "<a href='chat.php?destinataire=" . $result['pseudo'] . "&id=" . $result['id'] . "'>" . $result['pseudo'] . "</a><br>";
        }
        return $echo;
    }

    public function sendMessage()
    {
        $query = $this->bdd->prepare('insert into messages (from_id,to_id,message_content,message_date) VALUES (?,?,?,?)');
        $query->execute(array(
            $this->from,
            $this->to,
            $this->message,
            date('Y-m-d')
        ));
    }

    public function getMessage($from, $to)
    {
        $query = $this->bdd->prepare('select * from messages inner join user_info where messages.from_id = user_info.id_user AND from_id=? && to_id=? OR from_id=? && to_id=?');
        $query->execute(array(
            $from,
            $to,
            $to,
            $from
        ));
        $echo = "";
        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $echo .= '<div class="container">
            <p>From: ' . $result['surname'] . '</p>
            <p>' . $result['message_content'] . '</p>
            <span class="time-right">' . $result['message_date'] . '</span>
          </div>';
        }
        return $echo;
    }
}
