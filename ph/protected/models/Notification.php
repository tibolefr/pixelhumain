<?php
/*
- system notifications are saved in the notification collection
- citizen Notifications are saved in the citizen collection under the notification node
 */
class Notification 
{

    // A Citizen Notificaiton is saved in the Citizen Collection
    public static function saveCitizenNotification($params) {
        PHDB::update("citoyens", array("_id" => new MongoId($params['notifyUser'])), 
            array('$push' => array( Citoyen::NODE_NOTIFICATIONS => $notification )) );
    }

     /*
     * Save a certain Notification to the notification table
     * if notifyUser param is set, an entry is added to the citizen collection for the front end to pick up
     * 
     * */

    public static function saveNotification($params) {
        
         $params["created"] = time();
        
        if(isset($params['notifyUser'])){
            
            //insert in citoyen collection
            self::saveCitizenNotification($params);
            unset($params['notifyUser']);
        }

        if(self::isAdminNotificationActivated())
            self::saveAdminNotification($params);

    }

    //The administrators are notified if the parameter 'adminNotification' is set in the phConfig.php file
    private static function isAdminNotificationActivated() {

        if(Yii::app()->params["adminNotification"] == "true") {
            return true;
        } else {
            return false;
        }

    }
}