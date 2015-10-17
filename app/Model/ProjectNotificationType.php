<?php

namespace Kanboard\Model;

/**
 * Project Notification Type
 *
 * @package  model
 * @author   Frederic Guillot
 */
class ProjectNotificationType extends NotificationType
{
    /**
     * SQL table name
     *
     * @var string
     */
    const TABLE = 'project_has_notification_types';

    /**
     * Get selected notification types for a given project
     *
     * @access public
     * @param integer  $project_id
     * @return array
     */
    public function getSelectedTypes($project_id)
    {
        $selectedTypes = $this->db
            ->table(self::TABLE)
            ->eq('project_id', $project_id)
            ->asc('notification_type')
            ->findAllByColumn('notification_type');

        return array_merge($this->getHiddenTypes(), $selectedTypes);
    }

    /**
     * Save notification types for a given project
     *
     * @access public
     * @param  integer  $project_id
     * @param  string[] $types
     * @return boolean
     */
    public function saveSelectedTypes($project_id, array $types)
    {
        $results = array();
        $this->db->table(self::TABLE)->eq('project_id', $project_id)->remove();

        foreach ($types as $type) {
            $results[] = $this->db->table(self::TABLE)->insert(array('project_id' => $project_id, 'notification_type' => $type));
        }

        return ! in_array(false, $results);
    }
}
