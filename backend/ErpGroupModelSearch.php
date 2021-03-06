<?php
namespace backend;

trait ErpGroupModelSearch
{
    public function getGroupsPath()
    {
        if (!$this->is_group || !$this->group_id)
            return [];
        
        $path = [];
        $connection = $this->getDb();
        
        $group_id = $this->group_id;
        do {
            $row = $connection->createCommand('SELECT `id`, `title`, `group_id` FROM `'.$this->tableName().'` WHERE `id`='.$group_id.' AND `is_group`=1 LIMIT 1')->queryOne();
            if ($row) {
                array_unshift($path, $row);
                $group_id = $row['group_id'];
            }
        } while ($row && $group_id);

        array_unshift($path, ['id'=>null, 'title'=>'ROOT']);
        return $path;
    }
}