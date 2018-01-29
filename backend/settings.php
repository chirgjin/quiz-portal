<?php
    //Settings.php
    
    require_once __DIR__ . "/base.class.php";

    class SETTINGS extends BASE_MODEL
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            parent::table("settings");
            parent::fields(array(
                "parameter","value"
            ));
        }

        /**
         * GET Setting.
         * 
         * @param string $prop Name of setting to fetch
         * 
         * @return mixed
         */
        public function _GET($prop) 
        {
            parent::set("parameter", $prop)->set("value",null);

            parent::fetch();

            return parent::get("value");
        }

        /**
         * Update/Set Setting
         * 
         * @param string $prop name of setting
         * @param string $val  value of setting
         * 
         * @return void
         */
        public function _SET($prop,$val,$store=null)
        {
            parent::set("parameter" , $prop)->set("value",$val);
            $this->update();
        }

        /**
         * Update function
         * 
         * @return void
         */
        public function update()
        {

            $sql = "UPDATE `" . parent::table() . "` SET `parameter` = :parameter , `value` = :value WHERE `parameter` = :parameter";

            parent::query(
                $sql,
                array(
                    "parameter" => parent::get("parameter"),
                    "value" => parent::get("value")
                )
            );

        }
    }

    /**
     * Function to get settings
     * Don't have to use class directly
     * 
     * @param string $prop Property Name
     * 
     * @return string
     */
    function setting_get($prop) {
        $setting = new SETTINGS;
        return $setting->_GET($prop);
    }


    /**
     * Function to update settings
     * Don't have to use class directly
     * 
     * @param string $prop Property Name
     * @param mixed  $val  Property Value
     * 
     * @return string
     */
    function setting_set($prop,$val) {
        $setting = new SETTINGS;
        $setting->_SET($prop,$val);
    }