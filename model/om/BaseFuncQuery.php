<?php


/**
 * Base class that represents a query for the 'func' table.
 *
 *
 *
 * @method     FuncQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     FuncQuery orderByFunc($order = Criteria::ASC) Order by the func column
 * @method     FuncQuery orderByDesc($order = Criteria::ASC) Order by the desc column
 * @method     FuncQuery orderByIdprofesor($order = Criteria::ASC) Order by the idprofesor column
 *
 * @method     FuncQuery groupById() Group by the id column
 * @method     FuncQuery groupByFunc() Group by the func column
 * @method     FuncQuery groupByDesc() Group by the desc column
 * @method     FuncQuery groupByIdprofesor() Group by the idprofesor column
 *
 * @method     FuncQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     FuncQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     FuncQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     Func findOne(PropelPDO $con = null) Return the first Func matching the query
 * @method     Func findOneOrCreate(PropelPDO $con = null) Return the first Func matching the query, or a new Func object populated from the query conditions when no match is found
 *
 * @method     Func findOneById(int $id) Return the first Func filtered by the id column
 * @method     Func findOneByFunc(string $func) Return the first Func filtered by the func column
 * @method     Func findOneByDesc(string $desc) Return the first Func filtered by the desc column
 * @method     Func findOneByIdprofesor(int $idprofesor) Return the first Func filtered by the idprofesor column
 *
 * @method     array findById(int $id) Return Func objects filtered by the id column
 * @method     array findByFunc(string $func) Return Func objects filtered by the func column
 * @method     array findByDesc(string $desc) Return Func objects filtered by the desc column
 * @method     array findByIdprofesor(int $idprofesor) Return Func objects filtered by the idprofesor column
 *
 * @package    propel.generator.mathgraph.om
 */
abstract class BaseFuncQuery extends ModelCriteria
{

    /**
     * Initializes internal state of BaseFuncQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'mathgraph', $modelName = 'Func', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FuncQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return    FuncQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FuncQuery) {
            return $criteria;
        }
        $query = new FuncQuery();
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
     * @return    Func|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ((null !== ($obj = FuncPeer::getInstanceFromPool((string)$key))) && $this->getFormatter()->isObjectFormatter()) {
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
     * @return    FuncQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(FuncPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return    FuncQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(FuncPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * @param     int|array $id The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    FuncQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }
        return $this->addUsingAlias(FuncPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the func column
     *
     * @param     string $func The value to use as filter.
     *            Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    FuncQuery The current query, for fluid interface
     */
    public function filterByFunc($func = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($func)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $func)) {
                $func = str_replace('*', '%', $func);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(FuncPeer::FUNC, $func, $comparison);
    }

    /**
     * Filter the query on the desc column
     *
     * @param     string $desc The value to use as filter.
     *            Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    FuncQuery The current query, for fluid interface
     */
    public function filterByDesc($desc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($desc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $desc)) {
                $desc = str_replace('*', '%', $desc);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(FuncPeer::DESC, $desc, $comparison);
    }

    /**
     * Filter the query on the idprofesor column
     *
     * @param     int|array $idprofesor The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    FuncQuery The current query, for fluid interface
     */
    public function filterByIdprofesor($idprofesor = null, $comparison = null)
    {
        if (is_array($idprofesor)) {
            $useMinMax = false;
            if (isset($idprofesor['min'])) {
                $this->addUsingAlias(FuncPeer::IDPROFESOR, $idprofesor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idprofesor['max'])) {
                $this->addUsingAlias(FuncPeer::IDPROFESOR, $idprofesor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }
        return $this->addUsingAlias(FuncPeer::IDPROFESOR, $idprofesor, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param     Func $func Object to remove from the list of results
     *
     * @return    FuncQuery The current query, for fluid interface
     */
    public function prune($func = null)
    {
        if ($func) {
            $this->addUsingAlias(FuncPeer::ID, $func->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

} // BaseFuncQuery
