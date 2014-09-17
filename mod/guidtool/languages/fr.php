<?php
/**
 * Elgg GUID Tool
 * 
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

$french = array(
	/**
	 * Menu items and titles
	 */
	'guidtool' => 'Outil GUID',
	'guidtool:browse' => 'Explorer les GUIDs',
	'guidtool:import' => 'Importer des données GUID',
	'guidtool:import:desc' => 'Collez les données à importer dans la fenetre suivante ; elles doivent impérativement être au format "%s".',

	'guidtool:pickformat' => 'Veuillez choisir le format que vous souhaitez utiliser pour importer ou exporter.',

	'guidbrowser:export' => 'Exporter',

	'guidtool:editguid' => 'Modifier le GUID : %s',
	'guidtool:viewguid' => 'Afficher le GUID : %s',
	
	'guidtool:regularview' => "Afficher l'entité (vue normale)",
	'guidtool:regularedit' => "Modifier l'entité (vue normale)",
	
	'guidtool:editguid:warning' => "<strong>ATTENTION : malgré l'intégration de quelques vérifications et protections préliminaires contre les erreurs de mannipulation les plus fréquentes lors d'une modification directe des propriétés d'une entité Elgg, cet outil doit être considéré comme potentiellement dangereux s'il est utilisé sans une compréhension en profondeur du modèle de données et de fonctionnement d'Elgg.</strong><br />Il fournit une interface qui permet de modifier directement une série de propriété généralement accessible seulement par des modificaitons directes en base de données, et qui ne sont généralement pas accessibles y compris aux administrateurs. D'un point de vue usages, cet outil facilite la modification des propriétaires et conteneurs, l'activation désactivation des entités Elgg, la modification des timestamps, etc.<br /><blockquote><strong>Cela peut être utile, mais de grands pouvoirs impliquent de grandes responsabilités : à n'utiliser qu'avec les plus grandes précautions !!</strong></blockquote><br />",
	
	'guidtool:edit:fields' => "Métadonnées à modifier",
	'guidtool:edit:fields:details' => "Par défaut, aucune métadonnée ne peut être modifiée : vous devez spécifier manuellement les métadonnées à modifier à chaque fois que vous souhiatez changer leur valeur. Veuillez utiliser des virgules pour séparer les noms des métadonnées. Les espaces ne sont pas pris en compte.",
	
	'guidtool:deleted' => 'GUID %d supprimé',
	'guidtool:notdeleted' => 'GUID %d non supprimé',
	
	'guidtool:entity:enabled' => "Entité activée (visible)",
	'guidtool:entity:disabled' => "Entité désactivée (cachée)",
	'guidtool:entity:enable' => "Activer l'entité",
	'guidtool:entity:disable' => "Désactiver l'entité",
	
);

add_translation("fr",$french);


