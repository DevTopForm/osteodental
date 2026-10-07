<?php

namespace App\Item;

use App\Cabinet\User;
use App\Message;
use App\Model;
use App\Node;
use App\Node\Item;
use App\Registry;
use PHPMailer\PHPMailer\PHPMailer;

class Comment extends Model
{

    protected $table = 'result_comments';
    protected $defaultSorter = 'date';
    protected $defaultOrder = 'DESC';

    protected function prepareData()
    {
        $this->node = new Node($this->node);
        if (!empty($this->item)) {
            $this->item = new Item($this->node->getTable(), $this->item);
        }
        if (!empty($this->user)) {
            $this->user = new User($this->user);
        }
    }

    protected function getData()
    {
        $data = [
            'node' => $this->node->id,
            'item' => empty($this->item) ? 0 : $this->item->id,
            'date' => empty($this->date) ? time() : $this->date,
            'user' => empty($this->user) ? 0 : $this->user->id,
            'email' => empty($this->email) ? '' : $this->email,
            'name' => empty($this->name) ? '' : $this->name,
            'text' => empty($this->text) ? '' : $this->text,
            'parent' => empty($this->parent) ? '' : $this->parent,
            'public' => empty($this->public) ? 0 : 1,
        ];
        return $data;
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->user)) {
            if (empty($this->name)) {
                $valid = false;
                $this->errors[] = new Message('Необходимо заполнить поле «Фамилия Имя»', 'error');
            }
        }
        if (empty($this->text)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Ваш отзыв»', 'error');
        }
        return $valid;
    }

    public static function getItemComments($node, $item)
    {
        return static::getList(
            [
                'filters' => array(sprintf("node=%d", $node), sprintf("item=%d", $item)),
                'sorters' => array('date ASC')
            ]
        );
    }

    public function notify()
    {
        $settings = Registry::get('settings');

        $email = $settings->getSiteParams('email_comment');
        $site = $settings->getSiteParams('sitename');

        if (empty($email)) {
            return;
        }

        $subject = sprintf('На сайте %s добавлен новый отзыв', $site);

        $mail = new PHPMailer();

        $from = $settings->getSiteParams('from_email');
        $mail->From = empty($from) ? ("noreply@" . $_SERVER['SERVER_NAME']) : $from;
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', $subject);
        $mail->CharSet = 'Windows-1251';
        $mail->SingleTo = true;
        $mail->ContentType = 'text/html';
        $mail->AddAddress($email, $email);
        $template = '
			<html>
				<head><title>%s</title></head>
				<body>
					<h3>%s</h3>
					<p>Зайдите в <a href="http://%s/adm/comment/%s/edit">административный интерфейс</a>, чтобы отредактировать или просмтотреть этот комментарий</p>
				</body>
			</html>
		';
        $content = sprintf($template, $subject, $subject, $_SERVER['HTTP_HOST'], $this->id);
        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $content));
        $mail->Send();
    }

    public function prepareDelete()
    {
        $list = static::getListByKey('parent', $this->id)->getItems();
        foreach ($list as $item) {
            $item->delete();
        }
    }

    public function getAuthor()
    {
        return empty($this->user) ? $this->name : $this->user->getName();
    }
}

?>
