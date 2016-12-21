##### TOOLS #####
These tools are handy for administrators and allow them to perform some exceptional tasks.


## disable_threads :
This tool is for sites which used the "threads" plugin, and now do not want to use it anymore. 
Symptoms : all previous comments created while "threads" was active become invisible when disabling the plugin. Tech tip : they are in fact object entities, and not annotations, and are not handled by Elgg display views...
=> This tools allows administrators to convert "threads" comments to regular comments. 
Note : comment tree is lost, as topicreply objects and relations are converted into plain annotations. Former objects are deleted only if annotation was created.



