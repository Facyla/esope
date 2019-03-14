<?php

if (tooltip_editor_can_edit()) {
	ElggSession::offsetSet('tooltip_editor_enabled', 0);
	system_message(elgg_echo('tooltip_editor:message:disabled'));
}
else {
	ElggSession::offsetSet('tooltip_editor_enabled', 1);
	system_message(elgg_echo('tooltip_editor:message:enabled'));
}

forward(REFERER);