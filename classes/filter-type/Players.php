<?php

use Illuminate\Support;
require_once('classes/interfaces/ManageableExportInterface.php');

class Players implements ManageableExportInterface
{
    public $args;

    public function __construct($args) {
        $this->args = $args;
    }

    public function getData()
    {
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];

        $search = $this->args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });

        return $this->getPlayers($search);

    }

    public function getPlayers($search) {
        $where = [];
        if ($search->has('playerId')) $where[] = "roster.id = '" . $search['playerId'] . "'";
        if ($search->has('player')) $where[] = "roster.name = '" . $search['player'] . "'";
        if ($search->has('team')) $where[] = "roster.team_code = '" . $search['team']. "'";
        if ($search->has('position')) $where[] = "roster.position = '" . $search['position'] . "'";
        if ($search->has('country')) $where[] = "roster.nationality = '" . $search['country'] . "'";
        $where = implode(' AND ', $where);
        $sql = "
            SELECT roster.*
            FROM roster
            WHERE $where";
        return collect(query($sql))
            ->map(function($item, $key) {
                unset($item['id']);
                return $item;
            });
    }
}