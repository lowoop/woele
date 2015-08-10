<?php
/**
 * This model behavior builds a date range search condition.
 */
class DateRangeSearchBehavior extends CActiveRecordBehavior
{
    /**
     * @param the default 'from' date when nothing is entered.
     */
    public $dateFromDefault = '1970-01-01 00:00:00';
 
    /**
     * @param the default 'to' date when nothing is entered.
     */
    public $dateToDefault = '2038-01-19 03:14:07';

    /**
     * @param 时间格式(integer 或者 datetime), 默认integer
     */
    public $dateFormat = 'integer';
 
    /*
     * Date range search criteria
     * public $attribute name of the date attribute
     * public $value value of the date attribute
     * @return instance of CDbCriteria for the model's search() method
     */
    public function dateRangeSearchCriteria($attribute, $value)
    {
        $criteria = new CDbCriteria;
        if (is_array($value))
        {
            if (!empty($value[0]) || !empty($value[1]))
            {
                // Set the date 'from' variable to the first value in the array
                $dateFrom = $value[0];
                empty($dateFrom) && $dateFrom = $this->dateFromDefault;
 
                // Set the date 'to' variable to the second value in the array
                $dateTo = $value[1];
                empty($dateTo) && $dateTo = $this->dateToDefault;
 
                // Check if the 'from' date is greater than the 'to' date
                if ($dateFrom > $dateTo)
                {
                    list($dateFrom, $dateTo) = array($dateTo, $dateFrom);
                }
 
                // Add a BETWEEN condition to the search criteria
                switch ($this->dateFormat) {
                    case 'datetime':
                        $criteria->addBetweenCondition($attribute, $dateFrom, $dateTo);
                        break;
                    case 'integer':
                    default:
                        $criteria->addBetweenCondition($attribute, strtotime($dateFrom), strtotime($dateTo));
                        break;
                }
                
            }
        }
        else
            $criteria->compare($attribute, $value);
        return $criteria;
    }
}