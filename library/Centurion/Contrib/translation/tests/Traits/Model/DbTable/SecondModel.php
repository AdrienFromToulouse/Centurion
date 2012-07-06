<?php
/**
 * @class Translation_Test_Traits_Model_DbTable_SecondModel
 * @package Tests
 * @subpackage Translatable
 * @author Richard Déloge, rd@octaveoctave.com
 *
 * Model of test to check is the behavior of the trait translation is the excepted behavior.
 *
 * This model contains 7 fields :
 *      - id
 *      - original_id
 *      - language_id
 *      - title (non-translatable)
 *      - content (translatable)
 *      - is_active (non translatable)
 *
 * A dependant relation : first
 *
 */
require_once dirname(__FILE__) . '/SecondModel.php';
require_once dirname(__FILE__) . '/ThirdModel.php';
require_once dirname(__FILE__) . '/FourthModel.php';
class Translation_Test_Traits_Model_DbTable_SecondModel
    extends Asset_Model_DbTable_Abstract
    implements Translation_Traits_Model_DbTable_Interface{

    protected $_primary = 'id';

    protected $_name = 'test_m_translation_second_model';

    protected $_meta = array('verboseName'   => 'test_translation_second',
                             'verbosePlural' => 'test_translations_second');

    protected $_rowClass = 'Translation_Test_Traits_Model_DbTable_Row_SecondModel';

    protected $_referenceMap = array(
    );

    protected $_dependentTables = array(
        'first'          =>  'Translation_Test_Traits_Model_DbTable_FirstModel',
    );

    public function getTranslationSpec(){
        return array(
            Translation_Traits_Model_DbTable::TRANSLATED_FIELDS => array(
                'content',
            ),
            Translation_Traits_Model_DbTable::DUPLICATED_FIELDS => array(
                'title',
                'is_active'
            ),
            Translation_Traits_Model_DbTable::SET_NULL_FIELDS => array()
        );
    }

    protected function _createTable()
    {
        $this->getDefaultAdapter()->query(<<<EOS
            CREATE TABLE IF NOT EXISTS `test_m_translation_first_model` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `original_id` int(11) DEFAULT NULL,
              `language_id` int(10) unsigned NOT NULL,
              `title` varchar(100) NOT NULL,
              `content` text,
              `second1_id` int(11) DEFAULT NULL,
              `second2_id` int(11) DEFAULT NULL,
              `is_active` int(1) NOT NULL DEFAULT '0',
              `slug` varchar(150) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `original_id` (`original_id`),
              KEY `language_id` (`language_id`),
              KEY `second1_id` (`second1_id`),
              KEY `second2_id` (`second2_id`),
              KEY `is_active` (`is_active`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

EOS
        );
    }

    protected function _destructTable()
    {
        $this->getDefaultAdapter()->query('DROP TABLE IF EXISTS `{$this->_name}`;');
    }
}
