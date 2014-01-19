<?php


/**
 * Base class that represents a query for the 'user' table.
 *
 *
 *
 * @method     UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     UserQuery orderByNick($order = Criteria::ASC) Order by the nick column
 * @method     UserQuery orderByPass($order = Criteria::ASC) Order by the pass column
 * @method     UserQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     UserQuery orderByRole($order = Criteria::ASC) Order by the role column
 *
 * @method     UserQuery groupById() Group by the id column
 * @method     UserQuery groupByNick() Group by the nick column
 * @method     UserQuery groupByPass() Group by the pass column
 * @method     UserQuery groupByName() Group by the name column
 * @method     UserQuery groupByRole() Group by the role column
 *
 * @method     UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method     User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method     User findOneById(int $id) Return the first User filtered by the id column
 * @method     User findOneByNick(string $nick) Return the first User filtered by the nick column
 * @method     User findOneByPass(string $pass) Return the first User filtered by the pass column
 * @method     User findOneByName(string $name) Return the first User filtered by the name column
 * @method     User findOneByRole(string $role) Return the first User filtered by the role column
 *
 * @method     array findById(int $id) Return User objects filtered by the id column
 * @method     array findByNick(string $nick) Return User objects filtered by the nick column
 * @method     array findByPass(string $pass) Return User objects filtered by the pass column
 * @method     array findByName(string $name) Return User objects filtered by the name column
 * @method     array findByRole(string $role) Return User objects filtered by the role column
 *
 * @package    propel.generator.mathgraph.om
 */
abstract class BaseUserQuery extends ModelCriteria
{

    /**
     * Initializes internal state of BaseUserQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'mathgraph', $modelName = 'User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return    UserQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserQuery) {
            return $criteria;
        }
        $query = new UserQuery();
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
     * @return    User|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ((null !== ($obj = UserPeer::getInstanceFromPool((string)$key))) && $this->getFormatter()->isObjectFormatter()) {
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
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        return $this->addUsingAlias(UserPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        return $this->addUsingAlias(UserPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * @param     int|array $id The value to use as filter.
     *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }
        return $this->addUsingAlias(UserPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the nick column
     *
     * @param     string $nick The value to use as filter.
     *            Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterByNick($nick = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nick)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nick)) {
                $nick = str_replace('*', '%', $nick);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(UserPeer::NICK, $nick, $comparison);
    }

    /**
     * Filter the query on the pass column
     *
     * @param     string $pass The value to use as filter.
     *            Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterByPass($pass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pass)) {
                $pass = str_replace('*', '%', $pass);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(UserPeer::PASS, $pass, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * @param     string $name The value to use as filter.
     *            Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(UserPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the role column
     *
     * @param     string $role The value to use as filter.
     *            Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function filterByRole($role = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($role)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $role)) {
                $role = str_replace('*', '%', $role);
                $comparison = Criteria::LIKE;
            }
        }
        return $this->addUsingAlias(UserPeer::ROLE, $role, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param     User $user Object to remove from the list of results
     *
     * @return    UserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserPeer::ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

} // BaseUserQuery
