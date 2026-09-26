<?php

namespace App\Repository\Interface;


interface PageProductInterface
{
    public function getAllData();
    // public function store($data = []);
    public function edit($id);
    public function update($id);
    public function active($id);
    public function inactive($id);
    public function delete($id);
}
