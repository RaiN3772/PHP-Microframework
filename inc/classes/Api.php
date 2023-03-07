<?php

class Api extends Database
{
    private $key;
    private $endpoints = [];
    private $status;
    private $label;
    private $isValid = false;

    public function __construct($key = null) {
        if (!is_null($key) && $this->validate_key($key)->rowCount() == 1) {
            $sql = $this->fetch_api($key)->fetch();
            $this->key = $sql['id'];                         
            $this->endpoints = explode('/', $sql['endpoint']);
            $this->status = $sql['status'];
            $this->label = $sql['label'];
            $this->isValid = true;
        }
    }


    public function create_api($label = null, $endpoint) {
        return $this->insert('api', ['label' => $label, 'id' => $this->generateKey(), 'endpoint' => $endpoint]);
    }
    private function generateKey(): string {
        $key = substr(str_shuffle(implode("", array_merge(range(0, 9), range('a', 'z'), range('A', 'Z')))), 0, 20);
        if ($this->query("SELECT `id` FROM api WHERE `id` = :id", [':id' => $key])->rowCount() > 0) {
            return $this->generateKey();
        }
        return $key;
    }
    public function edit_api($key, $endpoints, $label = null) {
        return $this->update('api', ['endpoint' => $endpoints, 'label' => $label], ['id' => $key]);
    }
    public function delete_api($key) {
        return $this->update('api', ['status' => 'Inactive'], ['id' => $key]);
    }
    public function activate_api($key) {
        return $this->update('api', ['status' => 'Active'], ['id' => $key]);
    }

    public function fetch_apis() {
        return $this->query("SELECT * FROM api ORDER BY created_date DESC");
    }

    public function fetch_request($key) {
        return $this->query("SELECT * FROM api_requests WHERE api_key = :api_key", [':api_key' => $key]);
    }

    public function fetch_api($key) {
        return $this->select('api', '*', 'id = :key', [':key' => $key]);
    }

    private function validate_key($key) {
        return $this->select('api', 'id', 'id = :key', [':key' => $key]);
    }

    public function log_request($ip, $method, $endpoint) {
        return $this->insert('api_requests', ['api_key' => $this->key, 'ip_address' => $ip, 'request_method' => $method, 'request_endpoint' => $endpoint]);
    }

    public function update_request($key) {
        return $this->query("UPDATE api_requests SET request_date = now(), total_requests = total_requests + 1 WHERE api_key = :api_key", [':api_key' => $key]);
    }
    


    public function set_key($key) {
        $this->key = $key;
    }
    public function validate_status() {
        return $this->status;
    }
    public function get_endpoints() {
        return $this->endpoints;
    }
    public function get_key() {
        return $this->key;
    }
    public function isValid() {
        return $this->isValid;
    }
}