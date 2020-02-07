Config split configuration for Acquia Content Hub
====

This modules provides the following:

1. A config split entity that enables the Acquia Content Hub Publisher module
2. A config split entity that enables the Acquia Content Hub Subscriber module
3. Configuration with form to manage whether config split entities should be prevented from being exported to Content Hub.

On module install, the two config split entities are imported into active config, but they are both disabled by default (`status: false`).

The purpose of this module is provide a way to manage which sites in a multisite--such as on Acquia Cloud Site Factory--are set up as Content Hub publishers and subscribers. It also prevents config splits from being syndicated if so desired.

On a multisite, the splits can be enabled via overrides in `settings.php` or module config overrides. An alternative method would be to use config ignore to ignore the status property of either or both config split entities, and enable the splits manually via admin UI.

