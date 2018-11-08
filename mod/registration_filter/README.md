## Registration filter - Filtre d'inscription
Limits registration to users of specific email domains.
Only emails from the autorized domains will be allowed to register. 

This can be used to limit registration to known domains (only emails from those domains will be registered), or to exclude spam domains from registration (registration will always fail if email matches one of these domains). 

Email domain probe is performed by sending the activation email (only) to the allowed email: this ensures that only people originating from a trusted domain can register.

From a federated point of view, this transfers the responsability of trusting user accounts to the owners of the trusted domains. 


**Filtrage des adresses autorisées à créer un compte.** 
Activez ce plugin si vous souhaitez restreindre l'inscription exclusivement aux adresses email d'un ou de plusieurs noms de domaines.


## Installation
- copy plugin folder to /mod folder
- active plugin


## History
1.12.0 : new versionning

0.4.1 : 20150719
	- admin bypass to allow direct account creation by admin

0.4 : 20150610 - Updated to Elgg 1.11
	- renamed to registration_filter

0.3 : 20150525 - +blacklist mode

0.2.2 : activé à l'installation

0.2.1 : ajustement du filtrage du username : remplacement des '@' par des '_' mais on garde les '.' (le tiret n'étant pas un caractère valide)

0.2 : suppression du username (généré à partir de l'adresse mail d'inscription)

0.1 : première version opérationnelle
