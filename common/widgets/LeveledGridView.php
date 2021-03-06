<?php

namespace common\widgets;

use yii\grid\GridView;
use yii\helpers\Url;

class LeveledGridView extends GridView
{
    /**
     * Renders the table header.
     * @return string the rendering result.
     */
    public function renderTableHeader()
    {
        $html = parent::renderTableHeader();
        $path = $this->filterModel->getGroupsPath();
        if (!$path)
            return $html;

        $html_path = [];
        $searchModel = join('', array_slice(explode('\\', get_class($this->filterModel)), -1));
        foreach ($path as $row) {
            $html_path[] = '<a href="'.Url::current([$searchModel => ['group_id' => $row['id']]]).'">'.$row['title'].'</a>';
        }

        $html_path = implode(' &gt; ', $html_path);
        return $html . '<tr><td colspan="'.count($this->columns).'">Groups: '.$html_path.'</td></tr>';
    }

}