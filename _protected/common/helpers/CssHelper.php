<?php
namespace common\helpers;

use Yii;

/**
 * Css helper class.
 */
class CssHelper
{
    /**
     * Returns the appropriate css class based on the value of user $status.
     * NOTE: used in user/index view.
     *
     * @param  string $status User status.
     * @return string         Css class.
     */
    public static function statusCss($status)
    {
        if ($status === 'Active')
        {
            return "boolean-true";
        } 
        else 
        {
            return "boolean-false";
        }      
    }

    /**
     * Returns the appropriate css class based on the value of role $item_name.
     * NOTE: used in user/index view.
     *
     * @param  string $role Role name.
     * @return string       Css class.
     */
    public static function roleCss($role)
    {
        return "role-".$role."";    
    }

    /**
     * Returns the appropriate css class based on the value of Article $status.
     * NOTE: used in article/admin view.
     *
     * @param  string $status Article status.
     * @return string         Css class.
     */
    public static function generalStatusCss($status)
    {
        if ($status === Yii::t('app', 'Published'))
        {
            return "boolean-true";
        } 
        else 
        {
            return "boolean-false";
        }      
    }


    public static function tournamentStatusCss($status)
    {
        if ($status === Yii::t('app', 'Draft'))
        {
            return "grey";
        }
        else if ($status === Yii::t('app', 'Published'))
        {
            return "blue";
        }
        else if ($status === Yii::t('app', 'Running'))
        {
            return "green";
        }
        else if ($status === Yii::t('app', 'Finished'))
        {
            return "gold";
        }
        else if ($status === Yii::t('app', 'Abort'))
        {
            return "red";
        }
        else
        {
            return "red";
        }
    }
    
    /**
     * Returns the appropriate css class based on the value of Article $category.
     * NOTE: used in article/admin view.
     *
     * @param  string $category Article category.
     * @return string           Css class.
     */
    public static function generalCategoryCss($category)
    {
        if ($category === Yii::t('app', 'Starcraft'))
        {
            return "blue";
        }
        else if ($category === Yii::t('app', 'Warcraft'))
        {
            return "green";
        }
        else if ($category === Yii::t('app', 'Hearthstone'))
        {
            return "gold";
        }
        else if ($category === Yii::t('app', 'Diablo'))
        {
            return "red";
        }
        else if ($category === Yii::t('app', 'Overwatch'))
        {
            return "black";
        }
        else if ($category === Yii::t('app', 'ESport'))
        {
            return "grey";
        }
        else if ($category === Yii::t('app', 'General'))
        {
            return "yellow";
        }
        else 
        {
            return "white";
        }      
    }

    public static function galleriesCategoryCss($category)
    {
        if ($category === Yii::t('app', 'Economy'))
        {
            return "blue";
        }
        elseif ($category === Yii::t('app', 'Sport'))
        {
            return "green";
        }
        else
        {
            return "gold";
        }
    }
}