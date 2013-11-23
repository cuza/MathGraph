<?php


/**
 * Base class that represents a query for the 'alumno' table.
 *
 *
 *
 * @method     AlumnoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     AlumnoQuery orderByIduser($order = Criteria::ASC) Order by the iduser column
 * @method     AlumnoQuery orderByIdprofesor($order = Criteria::ASC) Order by the idprofesor column
 *
 * @method     AlumnoQuery groupById() Group by the id column
 * @method     AlumnoQuery groupByIduser() Group by the iduser column
 * @method     AlumnoQuery groupByIdprofesor() Group by the idprofesor column
 *
 * @method     AlumnoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     AlumnoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     AlumnoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     Alumno findOne(PropelPDO $con = null) Return the first Alumno matching the query
 * @method     Alumno findOneOrCreate(PropelPDO $con = null) Return the first Alumno matching the query, or a new Alumno object populated from the query conditions when no match is found
 *
 * @method     Alumno findOneById(int $id) Return the first Alumno filtered by the id column
 * @method     Alumno findOneByIduser(int $iduser) Return the first Alumno filtered by the iduser column
 * @method     Alumno findOneByIdprofesor(int $idprofesor) Return the first Alumno filtered by the idprofesor column
 *
 * @method     array findById(int $id) Return Alumno objects filtered by the id column
 * @method     array findByIduser(int $iduser) Return Alumno objects filtered by the iduser column
 * @method     array findByIdprofesor(int $idprofesor) Return Alumno objects filtered by the idprofesor column
 *
 * @package    propel.generator.mathgraph.om
 */
abstract class BaseAlumnoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of BaseAlumnoQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'mathgraph', $modelName = 'Alumno', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AlumnoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return    AlumnoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AlumnoQuery) {
            return $criteria;
        }
        $query = new AlumnoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }
        return $query;
    }

    /**
     * Find object by primary key
     * Use instance pooling to avoid a database query if the object exists
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return    Alumno|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ((null !== ($obj = AlumnoPeer::getInstanceFromPool((string)$key))) && $this->getFormatter()->isObjectFormatter()) {
            // the object is alredy in the instance pool
            return $obj;
        } else {
            // the object has not been requested yet, or the formatter is not an object formatter
            $criteria = $this->isKeepQuery() ? clone $this : $this;
            $stmt = $criteria
                ->filterByPrimaryKey($key)
                ->getSelectStatement($con);
            return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
        }
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        return $this
            ->filterByPrimaryKeys($keys)
            ->find($con);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return    AlumnoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(AlumnoPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return    AlumnoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(AlumnoPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * @param     int|array $id The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    AlumnoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }
        return $this->addUsingAlias(AlumnoPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the iduser column
     *
     * @param     int|array $iduser The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    AlumnoQuery The current query, for fluid interface
     */
    public function filterByIduser($iduser = null, $comparison = null)
    {
        if (is_array($iduser)) {
            $useMinMax = false;
            if (isset($iduser['min'])) {
                $this->addUsingAlias(AlumnoPeer::IDUSER, $iduser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iduser['max'])) {
                $this->addUsingAlias(AlumnoPeer::IDUSER, $iduser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(AlumnoPeer::IDUSER, $iduser, $comparison);
    }

    /**
     * Filter the query on the idprofesor column
     *
     * @param     int|array $idprofesor The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    AlumnoQuery The current query, for fluid interface
     */
    public function filterByIdprofesor($idprofesor = null, $comparison = null)
    {
        if (is_array($idprofesor)) {
            $useMinMax = false;
            if (isset($idprofesor['min'])) {
                $this->addUsingAlias(AlumnoPeer::IDPROFESOR, $idprofesor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idprofesor['max'])) {
                $this->addUsingAlias(AlumnoPeer::IDPROFESOR, $idprofesor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(AlumnoPeer::IDPROFESOR, $idprofesor, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param     Alumno $alumno Object to remove from the list of results
     *
     * @return    AlumnoQuery The current query, for fluid interface
     */
    public function prune($alumno = null)
    {
        if ($alumno) {
            $this->addUsingAlias(AlumnoPeer::ID, $alumno->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

} // BaseAlumnoQuery
