<?php
$url = elgg_get_site_url();

return array(
	'kdb' => 'Base de connaissance',
	'knowledge_database:homepage' => 'Base de connaissance',
	
	'knowledge_database:addresource' => 'Ajouter une nouvelle ressource',
	'knowledge_database:addfile' => '<i class="fa fa-file"></i><br />Publier un fichier',
	'knowledge_database:addbookmarks' => '<i class="fa fa-link"></i><br />Publier un lien vers une ressource web',
	'knowledge_database:addblog' => '<i class="fa fa-file-text-o"></i><br />Publier un article',
	'knowledge_database:addevent_calendar' => '<i class="fa fa-calendar"></i><br />Publier un événement',
	'knowledge_database:addpages' => '<i class="fa fa-file-text-o"></i><br />Publier une page wiki',
	'knowledge_database:addannouncements' => '<i class="fa fa-file-text-o"></i><br />Publier une annonce',
	'knowledge_database:kdb_group' => "Base de connaissance du groupe",
	
	// Errors
	'knowledge_database:kdbgrouperror' => "Groupe de la Knowledge Database non défini, veuillez contacter l'administrateur du site !",
	'knowledge_database:error:sitedisabled' => "La base de connaissances du site n'est pas activée.",
	'knowledge_database:contribute' => "enregistrer.",
	'knowledge_database:contribute' => "Pour contribuer à la Base de connaissance, veuillez vous <a href=\"" . $url . "login\">identifier sur le site</a> (vous pouvez avoir besoin de vous enregistrer d'abord).",
	
	'knowledge_database:publish:warning' => "<i class=\"fa fa-warning\"></i> Lorsque vous publiez des ressources, veuillez vérifier que vous avez le droit de le faire. Vous avez ce droit si vous êtes auteur et éditeur du document, ou si sa license autorise la publication. Si ce n'est pas le cas vous pouvez en démander l'autorisation à l'auteur.<br />Si la publication est interdite, vous pouvez tout de même publier un Lien web vers une ressource en ligne.",
	
	'knowledge_database:search:title' => "Rechercher dans la base de données",
	'knowledge_database:search:form:title' => "Rechercher dans la base de données",
	'knowledge_database:search:details' => "Vous pouvez rechercher dans la base de données en utilisant un seul, voire aucun critère, ou plusieurs critères à la fois. Il est recommandé de commencer par une recherche large, puis d'affiner les résultats s'il y en a trop.",
	'knowledge_database:advsearch' => "Recherche avancée",
	'knowledge_database:latestresources' => "Ressources au hasard",
	'knowledge_database:resultscount' => "%s ressources trouvées",
	'knowledge_database:resultscount1' => "%s ressource trouvée",
	'knowledge_database:noresult' => "Aucune ressource trouvée. Essayer d'utiliser moins de critères.",
	
	'knowledge_database:fulltextsearch' => "Recherche libre",
	'knowledge_database:fulltextsearch:details' => "Recherche un document par son titre et sa description (pas à l'intérieur des fichiers)",
	'knowledge_database:container_guid' => "Conteneur (GUID du groupe de la Knowledge Database)",
	
	// Settings
	'knowledge_database:settings:global' => "Paramètres généraux",
	'knowledge_database:settings:site' => "Base de connaissance du site",
	'knowledge_database:settings:field' => "Définition de \"%s\" (%s)",
	'knowledge_database:settings:field:edit' => "Configuration de \"%s\"",
	'knowledge_database:settings:field:edit:details' => "<strong>Type de champ&nbsp;:</strong> correspond à une vue input et output existante. Par ex. text, longtext, plaintext, select, date...<br />
	<strong>Category&nbsp;:</strong> facultatif, permet de regrouper les champs par groupe de champs<br />
	<strong>Read&nbsp;:</strong> \"yes\" ou \"no\", ou listes des rôles autorisés à lire le champ - permet de définir si ce champ est affiché. Se référer au code source pour des définitions plus avancées, selon les rôles et l'état du workflow.<br />
	<strong>Edit&nbsp;:</strong> permet de définir si ce champ peut être édité. Même configuration possible que pour \"read\".<br />
	<strong>Required&nbsp;:</strong> le champ doit être renseigné pour valider le formulaire<br />
	<strong>Multiple&nbsp;:</strong> (select) le champ accepte plusieurs valeurs<br />
	<strong>Autocomplete&nbsp;:</strong> (text) le champ propose des valeurs déjà saisies<br />
	<strong>Default&nbsp;:</strong> valeur par défaut du champ<br />
	<strong>Options values&nbsp;:</strong> (select) liste des valeurs possibles<br />",
	'knowledge_database:settings:fields:site' => "Base de connaissance globale (site)",
	'knowledge_database:settings:fields:group' => "Base de connaissance du groupe \"%s\"",
	'knowledge_database:settings:fields' => "Définition des métadonnées",
	'knowledge_database:settings:fields:details' => "Pour définir la liste des champs, indiquez un nom de métadonnée par ligne, ou séparez les noms par des virgules, par ex. metadata1, metadata2, etc.<br />
		Les noms des métadonnées devraient être saisis en minuscule, sans espace ni accent ou signe de ponctuation, et être uniques pour éviter tout risque de conflit avec d'autres metadonnées ou plugins.<br />
		<strong>Une bonne pratique vivement recommandée consiste à utiliser un prefixe, par ex.: <strong>kdb_</strong>metadata</strong>",
	'knowledge_database:settings:fields:config' => "Vous pouvez définir ici la configuration de chacun des champs.<br />Attention : certaines modifications ne seront visibles qu'après le rechargement de la page.",
	'knowledge_database:settings:actions:details' => "Pour définir les actions autorisées, vous pouvez utiliser :<br />
		 \"yes\" ou \"no\" pour une définition globale<br />
		 \"role1 | role2\" pour autoriser les rôles role1 et role2<br />
		 \"role1 (step1, step2) | role2 (step1)\" pour autoriser les rôles role1 dans certains états du workflow.",
	
	'knowledge_database:settings:mode' => "Mode de fonctionnement",
	'knowledge_database:settings:mode:site' => "Activer la base de connaissance globale (tout le site) ?",
	'knowledge_database:settings:kdb_group' => "Associer un groupe précis à la base de connaissance du site ?",
	'knowledge_database:settings:mode:pergroup' => "Activer une base de connaissance dans certains groupes ?",
	'knowledge_database:settings:mode:merge' => "Ajouter les champs du site à ceux du groupe (si les 2 sont activés) ?",
	'knowledge_database:settings:mode:merge:details' => "Si NON, seuls les champs du groupe seront utilisés pour publier et rechercher dans la base de connaissance de ce groupe. Si OUI, les champs du groupe et du site seront utilisés.",
	'knowledge_database:settings:globalsearch' => "Utiliser tous les champs dans la recherche globale (site + groupes) ?",
	'knowledge_database:settings:globalsearch:details' => "Si NON, seuls les champs du site seront utilisés. Si OUI, tous les champs définis dans tous les groupes seront utilisés pour rechercher dans la base de connaissance globale.",
	'knowledge_database:settings:inputs' => "Types champs de saisie utilisables",
	'knowledge_database:settings:inputs:details' => "Il s'agit des champs de saisie autorisés, soit les vues input/*. Ces vues doivent exister dans le système, et si possible une vue output/* correspondante également.",
	'knowledge_database:settings:subtypes' => "Types de publications concernées",
	'knowledge_database:settings:subtypes:details' => "Attention : il s'agit des contextes et non des subtypes ! (par ex. pages et non page et page_top).",
	'knowledge_database:settings:default' => "Par défaut",
	'knowledge_database:subtype' => "Types de contenus",
	'knowledge_database:subtype:all' => "Tous",
	'knowledge_database:subtype:bookmarks' => "Liens web",
	'knowledge_database:subtype:file' => "Document téléchargeable",
	'knowledge_database:subtype:blog' => "Article",
	'knowledge_database:subtype:pages' => "Page wiki",
	'knowledge_database:subtype:evnet_calendar' => "Evénement",
	'knowledge_database:subtype:announcements' => "Annonce",
	
	'knowledge_database:settings:keytitle' => "Options pour la métadonnée \"%s\"",
	'knowledge_database:settings:fields:notice' => "<strong>ATTENTION, IMPORTANT :</strong><ul>
		<li> - lorsque vous modifiez ces valeurs, ayez bien à l'esprit que tout changement de nom d'une option modifie la classification existante</li>
		<li> - Les noms de métadonnées peuvent être séparés en en indiquant une par ligne, ou en utilisant le séparateur \"|\", par ex. key1 | key2 | etc.</li>
		<li> - Les noms de ces métadonnées peuvent être traduits en utilisant les clefs de traduction 'knowledge_database:key:key1' => \"Nom en clair de Key 1\",</li>
		<li> - OU vous pouvez définir directement un nom en utilisant le séparateur clef-valeur \"::\" (mais en une seule langue dans ce cas), par ex.: key1::Nom en clair de Key 1</li>
		</ul>",
	'knowledge_database:settings:field:metadata' => "Configurer le champ pour la métadonnée&nbsp;: %s",
	'knowledge_database:define_field:success' => "La configuration a bien été enregistrée",
	'knowledge_database:define_field:error' => "Erreur, impossible d'enregistrer les données. Veuillez recharger la page et réessayer.",
	'knowledge_database:settings:field:title' => "Libellé du champ",
	'knowledge_database:settings:field:type' => "Type de champ",
	'knowledge_database:settings:field:category' => "Groupe de champs",
	'knowledge_database:settings:field:read' => "Lecture",
	'knowledge_database:settings:field:write' => "Ecriture",
	'knowledge_database:settings:field:required' => "Requis",
	'knowledge_database:settings:field:multiple' => "Multiple",
	'knowledge_database:settings:field:autocomplete' => "Autocomplétion",
	'knowledge_database:settings:field:addempty' => "Option vide",
	'knowledge_database:settings:field:defaultvalue' => "Valeur par défaut",
	'knowledge_database:settings:field:options_values' => "Valeurs disponibles",
	'knowledge_database:settings:field:save' => "Enregistrer la configuration",
	
	
	// Default config
	'knowledge_database:metadata:kdb_theme' => "Compétence",
	'knowledge_database:metadata:kdb_theme:details' => "Domaine de compétence du projet.",
	'knowledge_database:metadata:kdb_topic' => "Type(s) d'énergie(s)",
	'knowledge_database:metadata:kdb_topic:details' => "Précisez le type d'énergie(s) ou de technologie(s) auxquels cette ressource fait référence.",
	'knowledge_database:metadata:kdb_country' => "Pays",
	'knowledge_database:metadata:kdb_country:details' => "Si cette ressource concerne précisément certains pays, veuillez les sélectionner ici.",
	'knowledge_database:metadata:kdb_region' => "Région",
	'knowledge_database:metadata:kdb_region:details' => "Choisissez la région méditerranéenne concernée par cette ressource.",
	'knowledge_database:metadata:kdb_type' => "Type de document",
	'knowledge_database:metadata:kdb_type:details' => "Définissez plus précisément le type de ressource.",
	'knowledge_database:metadata:kdb_lang' => "Langue du document",
	'knowledge_database:metadata:kdb_lang:details' => "L'anglais et le français sont les langues de référence de cette base, mais tout document pertinent est le bienvenue. Veuillez inclure un bref résumé en anglais du contenu de cette ressource.",
	
	'knowledge_database:metadata:author' => "Organisation éditrice / auteur",
	'knowledge_database:metadata:author:details' => "Le nom de l'organisation qui a publié le document, ou l'auteur le cas échéant. Saisissez quelques lettres pour avoir des propositions, ou saisissez le nom complet s'il n'est pas proposé.",
	
	'knowledge_database:metadata:date' => "Année de publication",
	'knowledge_database:metadata:date:details' => "L'année de publication du document (notamment pour les fichiers téléchargeables)",
	
	'knowledge_database:default:kdb_theme' => "businesscreation::Business Creation | capacitybuilding::Capacity Building | costs::Costs | education::Education | entrepreneurship::Entrepreneurship | finance::Finance  | incubator::Incubator | innovation::Innovation | innovativeproject::Innovative projects | investment::Investment | marketdata::Market Data | orgnetwork::Organizations and networks | patent::Patents | phdprogram::PhD Program | policy::Policy | prices::Prices  | regframework::Regulatory framework | researchinfra::Research Infrastructure | research::Research | roadmap::Roadmap | security::Energy Security | taxes::Taxes | technology::Technology | techpark::Technological parks | trainingprogram::Training Program",
	'knowledge_database:default:kdb_topic' => "biogas::Biogas | biomasspower::Biomass power | coal::Coal | concentratedsolarpower::Concentrated Solar Power | demandresponse::Demand response | distributiongrid::Distribution grid | electricitygrid::Electricity Grid | energydemand::Energy Demand | energyefficiency::Energy Efficiency | energyefficiencyinbuildings::Energy Efficiency in Buildings | energyefficiencyinindustry::Energy Efficiency in Industry | energymanagement::Energy Management | energystorage::Energy Storage | energysupply::Energy Supply | forecasts::Forecasts | gas::Gas | geothermal::Geothermal | hydropower::Hydropower | marineenergy::Marine Energy | nuclearenergy::Nuclear Energy | renewableenergy::Renewable Energy | smartgrids::Smart Grids | solarpvpower::Solar PV Power | solarthermalenergy::Solar Thermal Energy | traditionalbiomass::Traditional Biomass | transmissiongrid::Transmission grid | wind::Wind",
	'knowledge_database:default:kdb_type' => "blog::Blog article | directorycontact::Directory Contacts & experts | euregulation::EU Regulation | event::Event | goodpractice::Good practice guide | interview::Interview | news::News | press::Press article | project::Project profile | report::Report | review::Review | scientific::Scientific article | tendercall::Tender/call document | tutorial::Tutorials | whitepaper::White paper",
	'knowledge_database:default:kdb_region' => "eu::EU | maghreb::Maghreb | mashreq::Mashreq | medregion::Mediterranean Region | mideast::Middle-East",
	'knowledge_database:default:kdb_lang' => "en::Anglais | fr::Français",
	'knowledge_database:default:kdb_country' => "AF::Afghanistan | AL::Albania | DZ::Algeria | AS::American Samoa | AD::Andorra | AO::Angola | AI::Anguilla | AQ::Antarctica | AG::Antigua and Barbuda | AR::Argentina | AM::Armenia | AW::Aruba | AU::Australia | AT::Austria | AZ::Azerbaijan | BS::Bahamas | BH::Bahrain | BD::Bangladesh | BB::Barbados | BY::Belarus | BE::Belgium | BZ::Belize | BJ::Benin | BM::Bermuda | BT::Bhutan | BO::Bolivia | BA::Bosnia and Herzegovina | BW::Botswana | BV::Bouvet Island | BR::Brazil | BQ::British Antarctic Territory | IO::British Indian Ocean Territory | VG::British Virgin Islands | BN::Brunei | BG::Bulgaria | BF::Burkina Faso | BI::Burundi | KH::Cambodia | CM::Cameroon | CA::Canada | CT::Canton and Enderbury Islands | CV::Cape Verde | KY::Cayman Islands | CF::Central African Republic | TD::Chad | CL::Chile | CN::China | CX::Christmas Island | CC::Cocos [Keeling] Islands | CO::Colombia | KM::Comoros | CG::Congo - Brazzaville | CD::Congo - Kinshasa | CK::Cook Islands | CR::Costa Rica | HR::Croatia | CU::Cuba | CY::Cyprus | CZ::Czech Republic | CI::Côte d’Ivoire | DK::Denmark | DJ::Djibouti | DM::Dominica | DO::Dominican Republic | NQ::Dronning Maud Land | DD::East Germany | EC::Ecuador | EG::Egypt | SV::El Salvador | GQ::Equatorial Guinea | ER::Eritrea | EE::Estonia | ET::Ethiopia | FK::Falkland Islands | FO::Faroe Islands | FJ::Fiji | FI::Finland | FR::France | GF::French Guiana | PF::French Polynesia | TF::French Southern Territories | FQ::French Southern and Antarctic Territories | GA::Gabon | GM::Gambia | GE::Georgia | DE::Germany | GH::Ghana | GI::Gibraltar | GR::Greece | GL::Greenland | GD::Grenada | GP::Guadeloupe | GU::Guam | GT::Guatemala | GG::Guernsey | GN::Guinea | GW::Guinea-Bissau | GY::Guyana | HT::Haiti | HM::Heard Island and McDonald Islands | HN::Honduras | HK::Hong Kong SAR China | HU::Hungary | IS::Iceland | IN::India | ID::Indonesia | IR::Iran | IQ::Iraq | IE::Ireland | IM::Isle of Man | IL::Israel | IT::Italy | JM::Jamaica | JP::Japan | JE::Jersey | JT::Johnston Island | JO::Jordan | KZ::Kazakhstan | KE::Kenya | KI::Kiribati | KW::Kuwait | KG::Kyrgyzstan | LA::Laos | LV::Latvia | LB::Lebanon | LS::Lesotho | LR::Liberia | LY::Libya | LI::Liechtenstein | LT::Lithuania | LU::Luxembourg | MO::Macau SAR China | MK::Macedonia | MG::Madagascar | MW::Malawi | MY::Malaysia | MV::Maldives | ML::Mali | MT::Malta | MH::Marshall Islands | MQ::Martinique | MR::Mauritania | MU::Mauritius | YT::Mayotte | FX::Metropolitan France | MX::Mexico | FM::Micronesia | MI::Midway Islands | MD::Moldova | MC::Monaco | MN::Mongolia | ME::Montenegro | MS::Montserrat | MA::Morocco | MZ::Mozambique | MM::Myanmar [Burma] | NA::Namibia | NR::Nauru | NP::Nepal | NL::Netherlands | AN::Netherlands Antilles | NT::Neutral Zone | NC::New Caledonia | NZ::New Zealand | NI::Nicaragua | NE::Niger | NG::Nigeria | NU::Niue | NF::Norfolk Island | KP::North Korea | VD::North Vietnam | MP::Northern Mariana Islands | NO::Norway | OM::Oman | PC::Pacific Islands Trust Territory | PK::Pakistan | PW::Palau | PS::Palestinian Territories | PA::Panama | PZ::Panama Canal Zone | PG::Papua New Guinea | PY::Paraguay | YD::People's Democratic Republic of Yemen | PE::Peru | PH::Philippines | PN::Pitcairn Islands | PL::Poland | PT::Portugal | PR::Puerto Rico | QA::Qatar | RO::Romania | RU::Russia | RW::Rwanda | RE::Réunion | BL::Saint Barthélemy | SH::Saint Helena | KN::Saint Kitts and Nevis | LC::Saint Lucia | MF::Saint Martin | PM::Saint Pierre and Miquelon | VC::Saint Vincent and the Grenadines | WS::Samoa | SM::San Marino | SA::Saudi Arabia | SN::Senegal | RS::Serbia | CS::Serbia and Montenegro | SC::Seychelles | SL::Sierra Leone | SG::Singapore | SK::Slovakia | SI::Slovenia | SB::Solomon Islands | SO::Somalia | ZA::South Africa | GS::South Georgia and the South Sandwich Islands | KR::South Korea | ES::Spain | LK::Sri Lanka | SD::Sudan | SR::Suriname | SJ::Svalbard and Jan Mayen | SZ::Swaziland | SE::Sweden | CH::Switzerland | SY::Syria | ST::São Tomé and Príncipe | TW::Taiwan | TJ::Tajikistan | TZ::Tanzania | TH::Thailand | TL::Timor-Leste | TG::Togo | TK::Tokelau | TO::Tonga | TT::Trinidad and Tobago | TN::Tunisia | TR::Turkey | TM::Turkmenistan | TC::Turks and Caicos Islands | TV::Tuvalu | UM::U.S. Minor Outlying Islands | PU::U.S. Miscellaneous Pacific Islands | VI::U.S. Virgin Islands | UG::Uganda | UA::Ukraine | SU::Union of Soviet Socialist Republics | AE::United Arab Emirates | GB::United Kingdom | US::United States | UY::Uruguay | UZ::Uzbekistan | VU::Vanuatu | VA::Vatican City | VE::Venezuela | VN::Vietnam | WK::Wake Island | WF::Wallis and Futuna | EH::Western Sahara | YE::Yemen | ZM::Zambia | ZW::Zimbabwe | AX::Åland Islands | ZZ::Unknown or Invalid Region",
	
	
);

