<?php

/**
 * Bakup Tool English language file.
 *
 */
return  array(
    'admin:backups' => 'Резервное копирование',
    'admin:backups:list' => 'Последние копии',
    'admin:backups:schedule' => 'Автоматическое создание',
    'backup-tool:create' => 'Создать новую копию',
    'backup-tool:settings:backup_dir' => 'Полный путь к папке для хранения резервных копий. Например: "/var/backups/elgg/".',
    'backup-tool:bad_backup_dir' => '!!! Папка для хранения резервных копий не определена или не существует. Пожалуйста укажите правильные <a href="' . elgg_get_site_url() . 'admin/plugin_settings/backup-tool"><u>настройки</u></a>',
    'backup-tool:create:success' => '%s успешно создан',
    'backup-tool:create:fail' => 'Во время создания файла возникла ошибка. Проверьте путь и права на запись в папку для хранения резервных копий',
    'backup-tool:message:removed' => '%s файл(ы) успешно удалены',
    'backup-tool:message:notexists' => 'Файл %s не существует',
    'backup-tool:message:nofiles' => 'Вы ничего не выбрали',
    'backup-tool:schedule:enable' => 'Включить расписание резеврного копирования',
    'backup-tool:schedule:period' => 'С какой периодичностью создавать резервные копии?',
    'backup-tool:schedule:hourly'  => 'Раз в час',
    'backup-tool:schedule:daily' => 'Раз в день',
    'backup-tool:schedule:weekly' => 'Раз в неделю',
    'backup-tool:schedule:monthly' => 'Раз в месяц',
    'backup-tool:schedule:yearly' => 'Раз в год',
    
    'backup-tool:schedule:delete' => 'Удалять резервные копии если они старше чем',
    'backup-tool:schedule:week' => 'недели',
    'backup-tool:schedule:month' => 'месяца',
    'backup-tool:schedule:year' => 'года',
    'backup-tool:schedule:never' => 'никогда',
    
    'backup-tool:settings:success' => 'Настройки разписания успешно сохранены',
    'backup-tool:settings:success:enable' => 'Автоматическое создание резервных копий включено',
    'backup-tool:settings:success:disable' => 'Автоматическое создание резервных копий выключено',
    
    'backuptool:schedule:button:enable' => 'Включить расписание',
    'backuptool:schedule:button:disable' => 'Выключить расписание',
    
    'backup-tool:schedule:settings' => 'Настройки расписания',
    'backup-tool:schedule:backup-options' => 'Настройки резервных копий',
    'admin:backups:settings' => 'Настройки плагина',
    'backuptool:schedule:button:apply'=>'Применить изменения',
    
    'backup-tool:settings:error:backup_options' => 'Вы должны выбрать хотя бы один параметр из списка в настройках резервных копий',
    'backup-tool:settings:backup_name' => 'Имя файла резервной копии',
    'backup-tool:restore:success' => 'Резервная копия успешно восстановлена',
    'backup-tool:restore' => 'Восстановить',
);

