<?php
class Vertragvertragsstatus_model extends DB_Model
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->dbTable = 'lehre.tbl_vertrag_vertragsstatus';
		$this->pk = array('vertragsstatus_kurzbz', 'vertrag_id');
        $this->hasSequence = false;
	}

    /**
     * Check if Vertrag has the given Vertragsstatus.
     * @param integer $vertrag_id
     * @param string $mitarbeiter_uid
     * @param string $vertragsstatus_kurzbz
     * @return array
     */
    public function hasStatus($vertrag_id, $mitarbeiter_uid, $vertragsstatus_kurzbz)
    {
        $this->addSelect('1');
        $this->addLimit(1);

        return $this->loadWhere(array(
            'vertrag_id' => $vertrag_id,
            'uid' => $mitarbeiter_uid,
            'vertragsstatus_kurzbz' => $vertragsstatus_kurzbz
        ));
    }

    /**
     * Get the latest Vertragsstatus for the given Vertrag and Mitarbeiter
     * @param integer $vertrag_id
     * @param string $mitarbeiter_uid
     * @return array
     */
    public function getLastStatus($vertrag_id, $mitarbeiter_uid)
    {
        $this->addSelect('vertragsstatus_kurzbz');
        $this->addOrder('datum', 'DESC');
        $this->addLimit(1);
        return $this->loadWhere(
            array(
                'vertrag_id' => $vertrag_id,
                'uid' => $mitarbeiter_uid
            )
        );
    }

    /**
     * Set Vertragsstatus for the given Vertrag and Mitarbeiter.
     * @param $vertrag_id
     * @param $vertragsstatus_kurzbz
     * @param $mitarbeiter_uid
     * @return array|null           On success object, retval is true. Null if status already exist for this vertrag.
     */
    public function setStatus($vertrag_id, $mitarbeiter_uid, $vertragsstatus_kurzbz){

        // Check if vertrag has already this status
        $result = $this->hasStatus($vertrag_id, $mitarbeiter_uid, $vertragsstatus_kurzbz);

        if (hasData($result))
        {
            return success(null); // return null if status is already set
        }

        // If new status should be 'akzeptiert', the latest status has to be 'erteilt'
        if ($vertragsstatus_kurzbz == 'akzeptiert')
        {
            $result = $this->getLastStatus($vertrag_id, $mitarbeiter_uid);
            $last_status = getData($result)[0]->vertragsstatus_kurzbz;

            if ($last_status != 'erteilt')
            {
                return success(null); // return null if latest status is not 'erteilt'
            }
        }

        // Set new status if passed all checks
        return $this->insert(
            array(
                'vertrag_id' => $vertrag_id,
                'vertragsstatus_kurzbz' => $vertragsstatus_kurzbz,
                'uid' => $mitarbeiter_uid,
                'datum' =>  $this->escape('NOW()'),
                'insertvon' =>  getAuthUID(),
                'insertamum' =>  $this->escape('NOW()')
            )
        );
    }

    /**
     * Updates the date of the given vertragsstatus.
     * @param $vertrag_id
     * @param $vertragsstatus_kurzbz
     * @return array
     */
    public function updateStatus($vertrag_id, $vertragsstatus_kurzbz)
    {
        $user = getAuthUID();
        return $this->update(
            array(
                'vertrag_id' => $vertrag_id,
                'vertragsstatus_kurzbz' => $vertragsstatus_kurzbz
            ),
            array(
                'datum' => $this->escape('NOW()'),
                'updateamum' => $this->escape('NOW()'),
                'updatevon' => $user,
            )
        );
    }

    /**
     * Deletes the given vertragsstatus of the contract.
     * @param $vertrag_id
     * @param $vertragsstatus_kurbz
     * @return array
     */
    public function deleteStatus($vertrag_id, $vertragsstatus_kurzbz)
    {
        return $this->delete(
            array(
                'vertrag_id' => $vertrag_id,
                'vertragsstatus_kurzbz' => $vertragsstatus_kurzbz
            )
        );
    }


}