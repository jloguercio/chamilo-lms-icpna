<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @license see /license.txt
 * @author autogenerated
 */
class AttendanceSheet extends \CourseEntity
{
    /**
     * @return \Entity\Repository\AttendanceSheetRepository
     */
     public static function repository(){
        return \Entity\Repository\AttendanceSheetRepository::instance();
    }

    /**
     * @return \Entity\AttendanceSheet
     */
     public static function create(){
        return new self();
    }

    /**
     * @var integer $c_id
     */
    protected $c_id;

    /**
     * @var integer $user_id
     */
    protected $user_id;

    /**
     * @var integer $attendance_calendar_id
     */
    protected $attendance_calendar_id;

    /**
     * @var boolean $presence
     */
    protected $presence;


    /**
     * Set c_id
     *
     * @param integer $value
     * @return AttendanceSheet
     */
    public function set_c_id($value)
    {
        $this->c_id = $value;
        return $this;
    }

    /**
     * Get c_id
     *
     * @return integer 
     */
    public function get_c_id()
    {
        return $this->c_id;
    }

    /**
     * Set user_id
     *
     * @param integer $value
     * @return AttendanceSheet
     */
    public function set_user_id($value)
    {
        $this->user_id = $value;
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function get_user_id()
    {
        return $this->user_id;
    }

    /**
     * Set attendance_calendar_id
     *
     * @param integer $value
     * @return AttendanceSheet
     */
    public function set_attendance_calendar_id($value)
    {
        $this->attendance_calendar_id = $value;
        return $this;
    }

    /**
     * Get attendance_calendar_id
     *
     * @return integer 
     */
    public function get_attendance_calendar_id()
    {
        return $this->attendance_calendar_id;
    }

    /**
     * Set presence
     *
     * @param boolean $value
     * @return AttendanceSheet
     */
    public function set_presence($value)
    {
        $this->presence = $value;
        return $this;
    }

    /**
     * Get presence
     *
     * @return boolean 
     */
    public function get_presence()
    {
        return $this->presence;
    }
}