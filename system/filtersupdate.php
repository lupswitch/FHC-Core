<?php
/**
 * Copyright (C) 2013 FH Technikum-Wien
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
 */

// Array of filters to be added or updated in the database
$filters = array(
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterSentApplicationAll',
		'description' => '{Alle}',
		'sort' => 1,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Abgeschickt - Alle",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "Nation"},
					{"name": "StgAbgeschickt"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"}
				],
				"filters": [
					{
						"name": "AnzahlAbgeschickt",
						"option": "",
						"condition": "0",
						"operation": "gt"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterSentApplication3days',
		'description' => '{"3 Tage keine Aktion"}',
		'sort' => 2,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Abgeschickt - 3 Tage keine Aktion",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "Nation"},
					{"name": "StgAbgeschickt"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"}
				],
				"filters": [
					{
						"name": "LastAction",
						"option": "days",
						"condition": "3",
						"operation": "gt"
					},
					{
						"name": "AnzahlAbgeschickt",
						"option": "",
						"condition": "0",
						"operation": "gt"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterNotSentApplicationAll',
		'description' => '{Alle}',
		'sort' => 1,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Nicht abgeschickt - Alle",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "Nation"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"
					},
					{"name": "StgNichtAbgeschickt"},
					{"name": "StgAbgeschickt"},
					{"name": "StgAktiv"},
					{"name": "Studiensemester"}
				],
				"filters": [
					{
						"name": "SendDate",
						"option": "",
						"condition": "",
						"operation": "nset"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterNotSentApplication14Days',
		'description' => '{"14 Tage keine Aktion"}',
		'sort' => 3,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Nicht abgeschickt - 14 Tage keine Aktion",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "Nation"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"},
					{"name": "StgNichtAbgeschickt"},
					{"name": "StgAbgeschickt"},
					{"name": "StgAktiv"},
					{"name": "Studiensemester"}
				],
				"filters": [
					{
						"name": "LastAction",
						"option": "days",
						"condition": "14",
						"operation": "gt"
					},
					{
						"name": "SendDate",
						"option": "",
						"condition": "",
						"operation": "nset"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterSentApplicationLt3days',
		'description' => '{"< 3 Tage"}',
		'sort' => 3,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Abgeschickt - Aktion innert der letzten 3 Tage",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "Nation"},
					{"name": "StgAbgeschickt"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"}
				],
				"filters": [
					{
						"name": "LastAction",
						"option": "days",
						"condition": "3",
						"operation": "lt"
					},
					{
						"name": "AnzahlAbgeschickt",
						"option": "",
						"condition": "0",
						"operation": "gt"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterNotSentApplication5DaysOnline',
		'description' => '{"5 Tage keine BewAktion"}',
		'sort' => 2,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Nicht abgeschickt - 5 Tage keine Aktion durch BewerberIn",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "Nation"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"},
					{"name": "StgNichtAbgeschickt"},
					{"name": "StgAbgeschickt"},
					{"name": "StgAktiv"},
					{"name": "Studiensemester"}
				],
				"filters": [
					{
						"name": "SendDate",
						"option": "",
						"condition": "",
						"operation": "nset"
					},
					{
						"name": "LastAction",
						"option": "days",
						"condition": "5",
						"operation": "gt"
					},
					{
						"name": "User/Operator",
						"option": "",
						"condition": "online",
						"operation": "contains"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterFreigegeben5days',
		'description' => '{"5 Tage Letzte Aktion"}',
		'sort' => 1,
		'default_filter' => true,
		'filter' => '
			{
				"name": "Freigegeben - 5 Tage Letzte Aktion",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "StgAbgeschickt"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"}
				],
				"filters": [
					{
						"name": "LastAction",
						"option": "days",
						"condition": "5",
						"operation": "lt"
					}
				]
			}
		',
		'oe_kurzbz' => null,
	),
	array(
		'app' => 'infocenter',
		'dataset_name' => 'PersonActions',
		'filter_kurzbz' => 'InfoCenterFreigegebenAlle',
		'description' => '{Alle}',
		'sort' => 2,
		'default_filter' => false,
		'filter' => '
			{
				"name": "Freigegeben - Alle",
				"columns": [
					{"name": "Vorname"},
					{"name": "Nachname"},
					{"name": "StgAbgeschickt"},
					{"name": "LastAction"},
					{"name": "User/Operator"},
					{"name": "LockUser"}
				],
				"filters": []
			}
		',
		'oe_kurzbz' => null,
	)
);

// Loop through the filters array
for ($filtersCounter = 0; $filtersCounter < count($filters); $filtersCounter++)
{
	$filter = $filters[$filtersCounter]; // single filter definition

	// If it's an array and contains the required number of elements
	// and contains the required fields
	if (is_array($filter) && count($filter) == 8
		&& isset($filter['app']) && isset($filter['dataset_name'])
		&& isset($filter['filter_kurzbz']) && isset($filter['description'])
		&& isset($filter['filter']))
	{
		$selectFilterQuery = 'SELECT filter_id
								FROM system.tbl_filters
							   WHERE app = '.$db->db_add_param($filter['app']).
							   ' AND dataset_name = '.$db->db_add_param($filter['dataset_name']).
							   ' AND filter_kurzbz = '.$db->db_add_param($filter['filter_kurzbz']);

		// If no error occurred while loading a filter from the DB
	   	if ($dbFilterDefinition = @$db->db_query($selectFilterQuery))
	   	{
			// If NO filters were loaded: insert
			if ($db->db_num_rows($dbFilterDefinition) == 0)
			{
				$insertFilterQuery = 'INSERT INTO system.tbl_filters (
											app,
											dataset_name,
											filter_kurzbz,
											person_id,
											description,
											sort,
											default_filter,
											filter,
											oe_kurzbz
										) VALUES (
											'.$db->db_add_param($filter['app']).',
											'.$db->db_add_param($filter['dataset_name']).',
											'.$db->db_add_param($filter['filter_kurzbz']).',
											null,
											'.$db->db_add_param($filter['description']).',
											'.$db->db_add_param($filter['sort']).',
											'.$db->db_add_param($filter['default_filter']).',
											'.$db->db_add_param($filter['filter']).',
											'.$db->db_add_param($filter['oe_kurzbz']).'
										)';

				if (!@$db->db_query($insertFilterQuery)) // checks query execution
				{
					echo '<strong>An error occurred while inserting filters: '.$db->db_last_error().'</strong><br>';
				}
				else
				{
					echo 'Filter added: '.$filter['app'].' - '.$filter['dataset_name'].' - '.$filter['filter_kurzbz'].'<br>';
				}
			}
			else // otherwise if the filter is already present in the DB: update
			{
				if ($filterDb = $db->db_fetch_object($dbFilterDefinition))
				{
					$updateFilterQuery = 'UPDATE system.tbl_filters SET
												app = '.$db->db_add_param($filter['app']).',
												dataset_name = '.$db->db_add_param($filter['dataset_name']).',
												filter_kurzbz = '.$db->db_add_param($filter['filter_kurzbz']).',
												person_id = null,
												description = '.$db->db_add_param($filter['description']).',
												sort = '.$db->db_add_param($filter['sort']).',
												default_filter = '.$db->db_add_param($filter['default_filter']).',
												filter = '.$db->db_add_param($filter['filter']).',
												oe_kurzbz = '.$db->db_add_param($filter['oe_kurzbz']).'
										   WHERE filter_id = '.$db->db_add_param($filterDb->filter_id);

					if (!@$db->db_query($updateFilterQuery)) // checks query execution
					{
						echo '<strong>An error occurred while inserting filters: '.$db->db_last_error().'</strong><br>';
					}
					else
					{
						echo 'Filter updated: '.$filter['app'].' - '.$filter['dataset_name'].' - '.$filter['filter_kurzbz'].'<br>';
					}
				}
			}
		}
		else // otherwise if errors occurred
		{
			echo '<strong>An error occurred while inserting filters: '.$db->db_last_error().'</strong><br>';
		}
	}
}