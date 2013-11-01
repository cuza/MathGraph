<?php



/**
 * This class defines the structure of the 'error' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.mathgraph.map
 */
class ErrorTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'mathgraph.map.ErrorTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return     void
     * @throws     PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('error');
        $this->setPhpName('Error');
        $this->setClassname('Error');
        $this->setPackage('mathgraph');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, 11, null);
        $this->addColumn('IDALUMNO', 'Idalumno', 'INTEGER', true, 11, null);
        $this->addColumn('PASO', 'Paso', 'INTEGER', true, 2, null);
        $this->addColumn('FECHA', 'Fecha', 'DATE', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // ErrorTableMap
