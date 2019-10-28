<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.10.2019
 * Time: 11:30
 */


namespace domain;

include 'Database.php';


class RecordService
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function InsertOrUpdate()
    {
        $userIp = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $url = $_SERVER['HTTP_REFERER'];
        $query = 'SELECT COUNT(*) FROM `user` WHERE `ip_address` = :ipAddress AND `user_agent` = :userAgent AND `page_url` = :pageUrl';
        $data = [
            ':ipAddress' => $userIp,
            ':userAgent' => $userAgent,
            ':pageUrl' => $url
        ];
        if ($this->db->checkExistRow($query, $data)) {
            $query = 'UPDATE `user` 
                      SET 
                          `views_count` = `views_count` + 1, 
                          `view_date` = :currentDate 
                      WHERE 
                            `ip_address` = :ipAddress 
                            AND `user_agent` = :userAgent 
                            AND `page_url` = :pageUrl';
        } else {
            $query = 'INSERT INTO `user` 
                            (`ip_address`, `user_agent`, `page_url`, `view_date`) 
                      VALUES (:ipAddress, :userAgent, :pageUrl, :currentDate)';
        }
        $data[':currentDate'] = time();
        $this->db->execute($query, $data);

    }
}