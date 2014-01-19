<?php


/**
 * Base class that represents a query for the 'error' table.
 *
 *
 *
 * @method     ErrorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ErrorQuery orderByIdalumno($order = Criteria::ASC) Order by the idalumno column
 * @method     ErrorQuery orderByPaso($order = Criteria::ASC) Order by the paso column
 * @method     ErrorQuery orderByFecha($order = Criteria::ASC) Order by the fecha column
 *
 * @method     ErrorQuery groupById() Group by the id column
 * @method     ErrorQuery groupByIdalumno() Group by the idalumno column
 * @method     ErrorQuery groupByPaso() Group by the paso column
 * @method     ErrorQuery groupByFecha() Group by the fecha column
 *
 * @method     ErrorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ErrorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ErrorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     Error findOne(PropelPDO $con = null) Return the first Error matching the query
 * @method     Error findOneOrCreate(PropelPDO $con = null) Return the first Error matching the query, or a new Error object populated from the query conditions when no match is found
 *
 * @method     Error findOneById(int $id) Return the first Error filtered by the id column
 * @method     Error findOneByIdalumno(int $idalumno) Return the first Error filtered by the idalumno column
 * @method     Error findOneByPaso(int $paso) Return the first Error filtered by the paso column
 * @method     Error findOneByFecha(string $fecha) Return the first Error filtered by the fecha column
 *
 * @method     array findById(int $id) Return Error objects filtered by the id column
 * @method     array findByIdalumno(int $idalumno) Return Error objects filtered by the idalumno column
 * @method     array findByPaso(int $paso) Return Error objects filtered by the paso column
 * @method     array findByFecha(string $fecha) Return Error objects filtered by the fecha column
 *
 * @package    propel.generator.mathgraph.om
 */
abstract class BaseErrorQuery extends ModelCriteria
{

    /**
     * Initializes internal state of BaseErrorQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'mathgraph', $modelName = 'Error', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ErrorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return    ErrorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ErrorQuery) {
            return $criteria;
        }
        $query = new ErrorQuery();
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
     * @return    Error|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ((null !== ($obj = ErrorPeer::getInstanceFromPool((string)$key))) && $this->getFormatter()->isObjectFormatter()) {
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
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(ErrorPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(ErrorPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * @param     int|array $id The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }
        return $this->addUsingAlias(ErrorPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the idalumno column
     *
     * @param     int|array $idalumno The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function filterByIdalumno($idalumno = null, $comparison = null)
    {
        if (is_array($idalumno)) {
            $useMinMax = false;
            if (isset($idalumno['min'])) {
                $this->addUsingAlias(ErrorPeer::IDALUMNO, $idalumno['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idalumno['max'])) {
                $this->addUsingAlias(ErrorPeer::IDALUMNO, $idalumno['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(ErrorPeer::IDALUMNO, $idalumno, $comparison);
    }

    /**
     * Filter the query on the paso column
     *
     * @param     int|array $paso The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function filterByPaso($paso = null, $comparison = null)
    {
        if (is_array($paso)) {
            $useMinMax = false;
            if (isset($paso['min'])) {
                $this->addUsingAlias(ErrorPeer::PASO, $paso['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paso['max'])) {
                $this->addUsingAlias(ErrorPeer::PASO, $paso['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(ErrorPeer::PASO, $paso, $comparison);
    }

    /**
     * Filter the query on the fecha column
     *
     * @param     string|array $fecha The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function filterByFecha($fecha = null, $comparison = null)
    {
        if (is_array($fecha)) {
            $useMinMax = false;
            if (isset($fecha['min'])) {
                $this->addUsingAlias(ErrorPeer::FECHA, $fecha['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fecha['max'])) {
                $this->addUsingAlias(ErrorPeer::FECHA, $fecha['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(ErrorPeer::FECHA, $fecha, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param     Error $error Object to remove from the list of results
     *
     * @return    ErrorQuery The current query, for fluid interface
     */
    public function prune($error = null)
    {
        if ($error) {
            $this->addUsingAlias(ErrorPeer::ID, $error->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

} // BaseErrorQuery
