## Inscript-Essonne : Filtre d'inscription
Limits registration to users of a specific email domain.
Only emails from the autorized domains will be allowed to register. 

This can be used to limit registration to known domains (only emails from those domains will be registered), or to exclude spam domains from registration (registration will always fail if email matches one of these domains). 

Email domain probe is performed by sending the activation email (only) to the allowed email: this ensures that only people originating from a trusted domain can register.

From a federated point of view, this transfers the responsability of trusting user accounts to the owners of the trusted domains. 


**Filtrage des adresses autorisées à créer un compte.** 
Activez ce plugin si vous souhaitez restreindre l'inscription exclusivement aux adresses email d'un ou de plusieurs noms de domaines.


## Installation
- copy plugin folder to /mod folder
- **rename** plugin folder to *adf_registration_filter*
- active plugin


## ROADMAP
- domain blacklist
- settings : whitelist + blacklist


