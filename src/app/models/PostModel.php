<?php

namespace app\models;

use Ordo\Model;

class PostModel extends Model
{
    static protected string $tableName = 'posts';
    static protected array $enabledCols = [];
}