<?php

class Settings extends Database {
    public function get($setting) {
        $sql = $this->query("SELECT setting_name, setting_value FROM settings WHERE setting_name = :setting", [':setting' => $setting])->fetch(PDO::FETCH_KEY_PAIR);
        return $sql[$setting];
    }

    public function description($setting) { 
        $sql = $this->query("SELECT setting_name, setting_description FROM settings WHERE setting_name = :setting", [':setting' => $setting])->fetch(PDO::FETCH_KEY_PAIR);
        return $sql[$setting];
    }
}
