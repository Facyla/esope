<?php
$url = elgg_get_site_url();

return array (
	'kdb' => 'Knowledge Database',
	'knowledge_database:homepage' => 'Knowledge Database',
	
	'knowledge_database:addresource' => 'Add a new ressource',
	'knowledge_database:addfile' => '<i class="fa fa-file"></i><br />Upload a file document',
	'knowledge_database:addbookmarks' => '<i class="fa fa-link"></i><br />Publish a link to an online ressource',
	'knowledge_database:addblog' => '<i class="fa fa-file-text-o"></i><br />Publish text',
	'knowledge_database:addevent_calendar' => '<i class="fa fa-calendar"></i><br />Publish an event',
	'knowledge_database:addpages' => '<i class="fa fa-file-text-o"></i><br />Publish a page',
	'knowledge_database:addannouncements' => '<i class="fa fa-file-text-o"></i><br />Publish an announcement',

	'knowledge_database:kdbgrouperror' => "Something's wrong with the Knowledge Database group, please contact the site administrator !",
	'knowledge_database:error:sitedisabled' => "Knowledge Database is not enabled for the whole site.",
	'knowledge_database:contribute' => "save.",
	'knowledge_database:contribute' => "To contribute to the Knowledge Database, please <a href=\"" . $url . "login\">login on the website</a> (you may need to register first).",
	
	'knowledge_database:publish:warning' => "<i class=\"fa fa-warning\"></i> When publishing content, please check that you actually have the right to publish it. You have this right if you are the author or publisher of a document, or if its license grants the right to publish it. If not, you should ask the author or publisher for its authorisation.<br />If publication is not allowed, please note that you can still publish a Web link to an online ressource instead.",
	
	'knowledge_database:search:title' => "Search the Knowledge Database",
	'knowledge_database:search:form:title' => "Search the Knowledge Database",
	'knowledge_database:search:details' => "You can search the database by using one, none or many search criteria. We suggest you start wide and refine your search if there are too much results.",
	'knowledge_database:advsearch' => "Advanced search",
	'knowledge_database:latestresources' => "Random ressources",
	'knowledge_database:resultscount' => "%s ressources found",
	'knowledge_database:resultscount1' => "%s ressource found",
	'knowledge_database:noresult' => "No ressource found. Try to refine your search criteria.",
	
	'knowledge_database:fulltextsearch' => "Title / description",
	'knowledge_database:fulltextsearch:details' => "Searches in the document title and description (not inside the uploaded files)",
	'knowledge_database:container_guid' => "Container (Knowledge Database group GUID)",
	
	// Settings
	'knowledge_database:settings:global' => "Global settings",
	'knowledge_database:settings:site' => "Site Knowledge Database settings",
	'knowledge_database:settings:field' => "Definition of \"%s\" (%s)",
	'knowledge_database:settings:field:edit' => "Configuration of \"%s\"",
	'knowledge_database:settings:field:edit:details' => "<strong>Type de champ&nbsp;:</strong> correpond à une vue input et output existante. Par ex. text, longtext, plaintext, select, date...<br />
	<strong>Category&nbsp;:</strong> facultatif, permet de regrouper les champs par groupe de champs<br />
	<strong>Read&nbsp;:</strong> \"yes\" ou \"no\" - permet de définir si ce champ est affiché. Se référer au code source pour des définitions plus avancées, selon les rôles et l'état du workflow.<br />
	<strong>Edit&nbsp;:</strong> permet de définir si ce champ peut être édité. Même configuration possible que pour \"read\".<br />
	<strong>Required&nbsp;:</strong> le champ doit être renseigné pour valider le formulaire<br />
	<strong>Multiple&nbsp;:</strong> (select) le champ accepte plusieurs valeurs<br />
	<strong>Autocomplete&nbsp;:</strong> (text) le champ propose des valeurs déjà saisies<br />
	<strong>Default&nbsp;:</strong> valeur par défaut du champ<br />
	<strong>Options values&nbsp;:</strong> (select) liste des valeurs possibles<br />",
	'knowledge_database:settings:fields:site' => "Global knowledge database",
	'knowledge_database:settings:fields:group' => "Knowledge database for group \"%s\"",
	'knowledge_database:settings:fields' => "Metadata definition",
	'knowledge_database:settings:fields:details' => "Pour définir la liste des champs, indiquez un nom de métadonnée par ligne, ou séparrez les noms par des virgules, par ex. metadata1, metadata2, etc.<br />
		Les noms devraient être saisis en minuscule, sans espace ni accent ou signe de ponctuation, et être uniques pour éviter tout risque de conflit avec d'autres metadonnées<br />
		<strong>Une bonne pratique vivement recommandée consiste à utiliser un prefixe, par ex.: kdb_metadata</strong>",
	'knowledge_database:settings:fields:config' => "Vous pouvez définir ici la configuration de chacun des champs.<br />Attention : certaines modifications ne seront visibles qu'après le rechargement de la page.",
	'knowledge_database:settings:actions:details' => "Pour définir les actions autorisées, vous pouvez utiliser :<br />
		 \"yes\" ou \"no\" pour une définition globale<br />
		 \"role1 | role2\" pour autoriser les rôles role1 et role2<br />
		 \"role1 (step1, step2) | role2 (step1)\" pour autoriser les rôles role1 dans certains états du workflow.",
	
	'knowledge_database:settings:mode' => "Behaviour mode",
	'knowledge_database:settings:mode:site' => "Enable the global knowledge base (for the whole site)?",
	'knowledge_database:settings:kdb_group' => "Associate a precise group to the site knowledge base?",
	'knowledge_database:settings:mode:pergroup' => "Enable the per-group knowledge base?",
	'knowledge_database:settings:mode:merge' => "Add site fields to group fields (if both are enabled)?",
	'knowledge_database:settings:mode:merge:details' => "If NO, only fields for the group will be used to publish and search content in the group's knowledge base. If YES, both site and groups fields will be used.",
	'knowledge_database:settings:globalsearch' => "Use all fields in the global search (site + groups)?",
	'knowledge_database:settings:globalsearch:details' => "If NO, only site fields will be used. If YES, all defined fields will be used to search the global knowledge base.",
	'knowledge_database:settings:inputs' => "Available fields input types",
	'knowledge_database:settings:inputs:details' => "Authorised fields input types for new knowledge base fields configuraiton. These should be the names of existing input/* views. These views have to exist in the system, and should also have a corresponding output/* view.",
	'knowledge_database:settings:subtypes' => "Relevant content types",
	'knowledge_database:settings:subtypes:details' => "Warning: please type contexts and not subtypes! (eg. pages and not page and page_top).",
	'knowledge_database:settings:default' => "By default",
	'knowledge_database:subtype' => "Content types",
	'knowledge_database:subtype:all' => "All content types",
	'knowledge_database:subtype:bookmarks' => "Web link",
	'knowledge_database:subtype:file' => "Downloadable document",
	'knowledge_database:subtype:blog' => "Article",
	'knowledge_database:subtype:pages' => "Page",
	'knowledge_database:subtype:event_calendar' => "Event",
	'knowledge_database:subtype:announcements' => "Announcement",
	
	'knowledge_database:settings:keytitle' => "Options for metadata \"%s\"",
	'knowledge_database:settings:fields:notice' => "CAUTION :<ul>
		<li> - when setting these values, keep in mind that any change in a option name (even case) will break existing classification (if you're not using keys)</li>
		<li> - Option keys can be separated using one per line, or by using \"|\" separator, e.g.: key1 | key2 | etc.</li>
		<li> - Option values can then be translated by using 'knowledge_database:key:key1' => \"Key 1 human readable name\",</li>
		<li> - OR Optional key-value separator \"::\" can be used for quicker config (but single language), e.g.: key1::Key 1 human readable name</li>
		</ul>",
	'knowledge_database:settings:field:metadata' => "Configure field for metadata: %s",
	'knowledge_database:define_field:success' => "Configuration successfully saved",
	'knowledge_database:define_field:error' => "Error, could not save data. Please reload page and try again.",
	'knowledge_database:settings:field:title' => "Field title",
	'knowledge_database:settings:field:type' => "Field type",
	'knowledge_database:settings:field:category' => "Fields group",
	'knowledge_database:settings:field:read' => "Read",
	'knowledge_database:settings:field:write' => "Edit",
	'knowledge_database:settings:field:required' => "Required",
	'knowledge_database:settings:field:multiple' => "Multiple",
	'knowledge_database:settings:field:autocomplete' => "Autocomplete",
	'knowledge_database:settings:field:defaultvalue' => "Default value",
	'knowledge_database:settings:field:options_values' => "Options values",
	'knowledge_database:settings:field:save' => "Save field configuration",
	
	
	// Default config
	'knowledge_database:metadata:kdb_theme' => "Competence",
	'knowledge_database:metadata:kdb_theme:details' => "Competence fields that the project or ressource focuses on.",
	'knowledge_database:metadata:kdb_topic' => "Energy topic",
	'knowledge_database:metadata:kdb_topic:details' => "Please specify the type of energy or energy technology the document makes reference to.",
	'knowledge_database:metadata:kdb_country' => "Country",
	'knowledge_database:metadata:kdb_country:details' => "Select any countries associated with the ressource (if relevant).",
	'knowledge_database:metadata:kdb_region' => "Region",
	'knowledge_database:metadata:kdb_region:details' => "Mediterranean regions concerned by the document, or where energy transition processes are similar or may provide valuable experience.",
	'knowledge_database:metadata:kdb_type' => "Document type",
	'knowledge_database:metadata:kdb_type:details' => "Please categorize more precisely the type of ressource.",
	'knowledge_database:metadata:kdb_lang' => "Document language",
	'knowledge_database:metadata:kdb_lang:details' => "English and french are prefered. Please provide an english summary.",
	
	'knowledge_database:metadata:author' => "Publishing organization / author",
	'knowledge_database:metadata:author:details' => "The organization that published the ressource, if applicable, or the author. Type of few letters to get suggestions, or add a new one if not available.",
	
	'knowledge_database:metadata:date' => "Year of ressource publication",
	'knowledge_database:metadata:date:details' => "The year when the publication was released or updated (applies mainly for downloadable files)",
	
	'knowledge_database:default:kdb_theme' => "businesscreation::Business Creation | capacitybuilding::Capacity Building | costs::Costs | education::Education | entrepreneurship::Entrepreneurship | finance::Finance  | incubator::Incubator | innovation::Innovation | innovativeproject::Innovative projects | investment::Investment | marketdata::Market Data | orgnetwork::Organizations and networks | patent::Patents | phdprogram::PhD Program | policy::Policy | prices::Prices  | regframework::Regulatory framework | researchinfra::Research Infrastructure | research::Research | roadmap::Roadmap | security::Energy Security | taxes::Taxes | technology::Technology | techpark::Technological parks | trainingprogram::Training Program",
	'knowledge_database:default:kdb_topic' => "biogas::Biogas | biomasspower::Biomass power | coal::Coal | concentratedsolarpower::Concentrated Solar Power | demandresponse::Demand response | distributiongrid::Distribution grid | electricitygrid::Electricity Grid | energydemand::Energy Demand | energyefficiency::Energy Efficiency | energyefficiencyinbuildings::Energy Efficiency in Buildings | energyefficiencyinindustry::Energy Efficiency in Industry | energymanagement::Energy Management | energystorage::Energy Storage | energysupply::Energy Supply | forecasts::Forecasts | gas::Gas | geothermal::Geothermal | hydropower::Hydropower | marineenergy::Marine Energy | nuclearenergy::Nuclear Energy | renewableenergy::Renewable Energy | smartgrids::Smart Grids | solarpvpower::Solar PV Power | solarthermalenergy::Solar Thermal Energy | traditionalbiomass::Traditional Biomass | transmissiongrid::Transmission grid | wind::Wind",
	'knowledge_database:default:kdb_type' => "blog::Blog article | directorycontact::Directory Contacts & experts | euregulation::EU Regulation | event::Event | goodpractice::Good practice guide | interview::Interview | news::News | press::Press article | project::Project profile | report::Report | review::Review | scientific::Scientific article | tendercall::Tender/call document | tutorial::Tutorials | whitepaper::White paper",
	'knowledge_database:default:kdb_region' => "eu::EU | maghreb::Maghreb | mashreq::Mashreq | medregion::Mediterranean Region | mideast::Middle-East",
	'knowledge_database:default:kdb_lang' => "en::English | fr::Français",
	'knowledge_database:default:kdb_country' => "AF::Afghanistan | AL::Albania | DZ::Algeria | AS::American Samoa | AD::Andorra | AO::Angola | AI::Anguilla | AQ::Antarctica | AG::Antigua and Barbuda | AR::Argentina | AM::Armenia | AW::Aruba | AU::Australia | AT::Austria | AZ::Azerbaijan | BS::Bahamas | BH::Bahrain | BD::Bangladesh | BB::Barbados | BY::Belarus | BE::Belgium | BZ::Belize | BJ::Benin | BM::Bermuda | BT::Bhutan | BO::Bolivia | BA::Bosnia and Herzegovina | BW::Botswana | BV::Bouvet Island | BR::Brazil | BQ::British Antarctic Territory | IO::British Indian Ocean Territory | VG::British Virgin Islands | BN::Brunei | BG::Bulgaria | BF::Burkina Faso | BI::Burundi | KH::Cambodia | CM::Cameroon | CA::Canada | CT::Canton and Enderbury Islands | CV::Cape Verde | KY::Cayman Islands | CF::Central African Republic | TD::Chad | CL::Chile | CN::China | CX::Christmas Island | CC::Cocos [Keeling] Islands | CO::Colombia | KM::Comoros | CG::Congo - Brazzaville | CD::Congo - Kinshasa | CK::Cook Islands | CR::Costa Rica | HR::Croatia | CU::Cuba | CY::Cyprus | CZ::Czech Republic | CI::Côte d’Ivoire | DK::Denmark | DJ::Djibouti | DM::Dominica | DO::Dominican Republic | NQ::Dronning Maud Land | DD::East Germany | EC::Ecuador | EG::Egypt | SV::El Salvador | GQ::Equatorial Guinea | ER::Eritrea | EE::Estonia | ET::Ethiopia | FK::Falkland Islands | FO::Faroe Islands | FJ::Fiji | FI::Finland | FR::France | GF::French Guiana | PF::French Polynesia | TF::French Southern Territories | FQ::French Southern and Antarctic Territories | GA::Gabon | GM::Gambia | GE::Georgia | DE::Germany | GH::Ghana | GI::Gibraltar | GR::Greece | GL::Greenland | GD::Grenada | GP::Guadeloupe | GU::Guam | GT::Guatemala | GG::Guernsey | GN::Guinea | GW::Guinea-Bissau | GY::Guyana | HT::Haiti | HM::Heard Island and McDonald Islands | HN::Honduras | HK::Hong Kong SAR China | HU::Hungary | IS::Iceland | IN::India | ID::Indonesia | IR::Iran | IQ::Iraq | IE::Ireland | IM::Isle of Man | IL::Israel | IT::Italy | JM::Jamaica | JP::Japan | JE::Jersey | JT::Johnston Island | JO::Jordan | KZ::Kazakhstan | KE::Kenya | KI::Kiribati | KW::Kuwait | KG::Kyrgyzstan | LA::Laos | LV::Latvia | LB::Lebanon | LS::Lesotho | LR::Liberia | LY::Libya | LI::Liechtenstein | LT::Lithuania | LU::Luxembourg | MO::Macau SAR China | MK::Macedonia | MG::Madagascar | MW::Malawi | MY::Malaysia | MV::Maldives | ML::Mali | MT::Malta | MH::Marshall Islands | MQ::Martinique | MR::Mauritania | MU::Mauritius | YT::Mayotte | FX::Metropolitan France | MX::Mexico | FM::Micronesia | MI::Midway Islands | MD::Moldova | MC::Monaco | MN::Mongolia | ME::Montenegro | MS::Montserrat | MA::Morocco | MZ::Mozambique | MM::Myanmar [Burma] | NA::Namibia | NR::Nauru | NP::Nepal | NL::Netherlands | AN::Netherlands Antilles | NT::Neutral Zone | NC::New Caledonia | NZ::New Zealand | NI::Nicaragua | NE::Niger | NG::Nigeria | NU::Niue | NF::Norfolk Island | KP::North Korea | VD::North Vietnam | MP::Northern Mariana Islands | NO::Norway | OM::Oman | PC::Pacific Islands Trust Territory | PK::Pakistan | PW::Palau | PS::Palestinian Territories | PA::Panama | PZ::Panama Canal Zone | PG::Papua New Guinea | PY::Paraguay | YD::People's Democratic Republic of Yemen | PE::Peru | PH::Philippines | PN::Pitcairn Islands | PL::Poland | PT::Portugal | PR::Puerto Rico | QA::Qatar | RO::Romania | RU::Russia | RW::Rwanda | RE::Réunion | BL::Saint Barthélemy | SH::Saint Helena | KN::Saint Kitts and Nevis | LC::Saint Lucia | MF::Saint Martin | PM::Saint Pierre and Miquelon | VC::Saint Vincent and the Grenadines | WS::Samoa | SM::San Marino | SA::Saudi Arabia | SN::Senegal | RS::Serbia | CS::Serbia and Montenegro | SC::Seychelles | SL::Sierra Leone | SG::Singapore | SK::Slovakia | SI::Slovenia | SB::Solomon Islands | SO::Somalia | ZA::South Africa | GS::South Georgia and the South Sandwich Islands | KR::South Korea | ES::Spain | LK::Sri Lanka | SD::Sudan | SR::Suriname | SJ::Svalbard and Jan Mayen | SZ::Swaziland | SE::Sweden | CH::Switzerland | SY::Syria | ST::São Tomé and Príncipe | TW::Taiwan | TJ::Tajikistan | TZ::Tanzania | TH::Thailand | TL::Timor-Leste | TG::Togo | TK::Tokelau | TO::Tonga | TT::Trinidad and Tobago | TN::Tunisia | TR::Turkey | TM::Turkmenistan | TC::Turks and Caicos Islands | TV::Tuvalu | UM::U.S. Minor Outlying Islands | PU::U.S. Miscellaneous Pacific Islands | VI::U.S. Virgin Islands | UG::Uganda | UA::Ukraine | SU::Union of Soviet Socialist Republics | AE::United Arab Emirates | GB::United Kingdom | US::United States | UY::Uruguay | UZ::Uzbekistan | VU::Vanuatu | VA::Vatican City | VE::Venezuela | VN::Vietnam | WK::Wake Island | WF::Wallis and Futuna | EH::Western Sahara | YE::Yemen | ZM::Zambia | ZW::Zimbabwe | AX::Åland Islands | ZZ::Unknown or Invalid Region",
	
	
);

