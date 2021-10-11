<?php

use Elgg\Database\Select;

$result = [
	'options' => advanced_statistics_get_default_chart_options('pie'),
];

$data = [];

// banned users

$qb = Select::fromTable('entities', 'e');
$qb->select('count(*) AS total');
$qb->join('e', 'metadata', 'md', 'e.guid = md.entity_guid');
$qb->where("e.type = 'user'");
$qb->andWhere("e.enabled = 'yes'");
$qb->andWhere("md.name = 'banned'");
$qb->andWhere("md.value = 'yes'");

$banned = (int) $qb->execute()->fetchColumn(0);

$data[] = [
	"banned [{$banned}]",
	$banned,
];

// unvalidated users
// note ADF : they are not necessarly disabled

$subquery = Select::fromTable('metadata', 'md');
$subquery->select('md.entity_guid');
$subquery->where("md.name = 'validated'");
$subquery->andWhere("md.value = '1'");

$qb = Select::fromTable('entities', 'e');
$qb->select('count(*) AS total');
$qb->where("e.type = 'user'");
$qb->andWhere("e.enabled = 'yes'");
$qb->andWhere($qb->compare('e.guid', 'NOT IN', $subquery->getSQL()));

$unvalidated = (int) $qb->execute()->fetchColumn(0);

$data[] = [
	"unvalidated [{$unvalidated}]",
	$unvalidated,
];

// not yet validated (= registered who haven't confirmed)
// note ADF : they are necessarly disabled
$subquery = Select::fromTable('metadata', 'md');
$subquery->select('md.entity_guid');
$subquery->where("md.name = 'validated'");
$subquery->andWhere("md.value = '1'");

$qb = Select::fromTable('entities', 'e');
$qb->select('count(*) AS total');
$qb->where("e.type = 'user'");
$qb->andWhere("e.enabled = 'no'");
$qb->andWhere($qb->compare('e.guid', 'NOT IN', $subquery->getSQL()));

$notvalidated = (int) $qb->execute()->fetchColumn(0);

$data[] = [
	"notvalidated [{$notvalidated}]",
	$notvalidated,
];

// disabled
// note ADF : as unvalidated are not necessarly disabled, count only the not-yet-validated, which are disabled
$qb = Select::fromTable('entities', 'e');
$qb->select('count(*) AS total');
$qb->where("e.type = 'user'");
$qb->andWhere("e.enabled = 'no'");

$disabled = (int) $qb->execute()->fetchColumn(0);

//$disabled = $disabled - $unvalidated;
$disabled = $disabled - $notvalidated;

$data[] = [
	"disabled [{$disabled}]",
	$disabled,
];

// active
$qb = Select::fromTable('entities', 'e');
$qb->select('count(*) AS total');
$qb->where("e.type = 'user'");

$active = (int) $qb->execute()->fetchColumn(0);
$active = $active - $disabled - $unvalidated - $notvalidated - $banned;

$data[] = [
	"active [{$active}]",
	$active,
];

$result['data'] = [$data];

echo json_encode($result);
