<?php
require_once(WWW_DIR."/lib/framework/db.php");

/**
 * This class looks up tv episode data.
 */
class Episode
{	
	/**
	 * Get an episodeinfo row by ID.
	 */
	public function getEpisodeInfoByID($episodeinfoID)
	{
		$db = new DB();
		return $db->queryOneRow(sprintf('SELECT * FROM episodeinfo WHERE ID = %d', $episodeinfoID));
	}

	/**
	 * Get an episodeinfo row by name.
	 */
	public function getEpisodeInfoByName($showtitle, $fullep, $epabsolute='0')
	{
		$db = new DB();
		
		if($epabsolute == '0') //as string - not int.
			if(!preg_match('/[21]\d{3}\/\d{2}\/\d{2}/', $fullep))
				$additionalSql = sprintf('AND fullep = %s', $db->escapeString($fullep));
			else	$additionalSql = sprintf('AND airdate LIKE %s', $db->escapeString($fullep.' %'));
		else $additionalSql = sprintf('AND epabsolute = %s', $db->escapeString($epabsolute));

		return $db->queryOneRow(sprintf('SELECT * FROM episodeinfo WHERE showtitle = %s %s', $db->escapeString($showtitle), $additionalSql));
	}
}