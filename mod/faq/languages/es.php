<?php

return array(
	// Main Title
	'faq' => "Preguntas frecuentes",
	'faq:title' => "Preguntas frecuentes",
	'faq:shorttitle' => "Ayuda",
	'faq:sidebar:categories' => "Categorías de preguntas frecuentes",

	'item:object:faq' => "Preguntas Frecuentes",

	// Add
	'faq:add' => "Nueva pregunta",
	'faq:add:title' => "Nueva pregunta frecuente",
	'faq:add:question' => "Pregunta",
	'faq:add:category' => "Categoría",
	'faq:add:answer' => "Respuesta",

	'faq:add:oldcat:please' => "Seleccione una categoría",
	'faq:add:oldcat:new' => "Introduzca una nueva categoría",

	'faq:add:check:question' => "Introduzca una pregunta",
	'faq:add:check:category' => "Introduzca una categoría",
	'faq:add:check:answer' => "Escriba una respuesta",

	'faq:add:error:invalid_input' => "Error al guardar: Entrada no válida. Por favor revise todos los campos.",
	'faq:add:error:save' => "Error no especificado al guardar.",
	'faq:add:success' => "Se ha añadido una nueva pregunta correctamente.",

	// Edit
	'faq:edit:title' => "Editar pregunta frecuente.",
	'faq:edit:error:invalid_input' => "Error al guardar: Entrada no válida. Por favor revise todos los campos.",
	'faq:edit:error:invalid_object' => "Error al editar: objeto no válido. Parece que la pregunta que está intentando editar no existe.",
	'faq:edit:error:save' => "Error no especificado al guardar.",
	'faq:edit:success' => "Pregunta editada correctamente.",

	// Delete
	'faq:delete:confirm' => "Está seguro de que desea borrar esta pregunta?",
	'faq:delete:success' => "Pregunta borrada correctamente.",
	'faq:delete:error:delete' => 'Ha fallado el borrado de la pregunta.',
	'faq:delete:error:invalid_object' => 'Error al borrar: No es una pregunta válida.',
	'faq:delete:error:invalid_input' => 'Error al borrar: No se ha indicado una pregunta a borrar.',

	// Settings
	'faq:settings:public' => "¿La pregunta debería estar disponible públicamente? Si no solo la verán los administradores.",
	'faq:settings:publicAvailable_sitemenu'  => "¿El sitio de las preguntas debería ser visible sin estar validado?",
	'faq:settings:publicAvailable_footerlink' => "El enlace a las preguntas frecuentes ¿debería ser visible en el pie de página para usuarios no validados?",
	'faq:settings:ask' => "¿Permitir a los usuarios hacer preguntas?",
	'faq:settings:minimum_search_tag_size' => "Tamaño mínimo para etiquetas de búsqueda:",
	'faq:settings:minimum_hit_count' => "Número mínimo de visitas:",

	// Search
	'faq:search:noresult' => "No se han encontrado resultados.",
	'faq:search:hitcount' => "Número de visitas:",
	'faq:search:title' => "Buscar en las preguntas frecuentes",
	'faq:search:label' => "Por favor, introduzca los términos a buscar en las preguntas frecuentes:",
	'faq:search:description' => "(La longitud mínima de los términos de búsqueda es %s caracteres. Un término debe aparecer al menos %s veces en la pregunta para que aparezca en los resultados.)",

	// List a category
	'faq:list:category_title' => "Categoría:",
	'faq:list:no_category' => "No se ha especificado una categoría válida.",
	'faq:list:edit:new_category' => "Por favor introduzca una nueva categoría.",
	'faq:list:edit:confirm:question' => "¿Está seguro de que quiere mover",
	'faq:list:edit:confirm:category' => "la/s pregunta/s a la categoría?",
	'faq:list:edit:category:please' => "Por favor seleccione una o más preguntas para moverlas.",
	'faq:list:edit:begin' => "Cambiar de categoría",
	'faq:list:edit:all' => "Seleccionar todo",
	'faq:list:edit:none' => "Deseleccionar todo",
	'faq:list:edit:select:choice' => "- Por favor seleccione una categoría",
	'faq:list:edit:select:new' => "- Crear una categoría",

	// Change category
	'faq:change_category:description' => "Seleccione al menos una de las preguntas anteriores para moverla a otra categoría. Después seleccione la nueva categoría debajo. (Ayuda: para cambiar el nombre a una categoría seleccione todas las preguntas de la categoría e introduzca el nuevo nombre de la categoría debajo)",
	'faq:change_category:new_category' => "Nueva categoría:",
	'faq:change_category:error:input' => "Texto de entrada no válido.",
	'faq:change_category:error:no_faq' => "No se ha provisto un objeto de Pregunta Frecuente",
	'faq:change_category:error:save' => "Ha habido un error guardando la pregunta. Por favor inténtelo otra vez.",
	'faq:change_category:success' => "La pregunta se ha guardado correctamente.",

	// Ask a question
	'faq:ask' => "Preguntar algo",
	'faq:ask:title' => "Preguntar algo",
	'faq:ask:label' => "¿No has resuelto tus dudas? Pregunta algo aquí:",
	'faq:ask:description' => "(Tu pregunta puede o no ser añadida a las preguntas frecuentes, pero en cualquier caso te contestaremos)",
	'faq:ask:button' => "Preguntar",
	'faq:ask:new_question:subject' => "Has enviado tu pregunta",
	'faq:ask:new_question:message' => "Gracias por hacernos llegar tu pregunta

Haremos lo posible por darte la mejor respuesta

%s

tan pronto como sea posible.

Puede que decidamos añadir tu pregunta a las preguntas frecuentes. En la respuesta que te demos te indicaremos si la vamos a añadir para que sirva para otras personas.",

	'faq:ask:new_question:send' => "Se ha añadido tu pregunta. Recibirás una notificación al respecto.",
	'faq:ask:error:not_send' => "Se ha añadido tu pregunta, pero no te lo hemos podido notificar.",
	'faq:ask:error:save' => "Ha habido un error guardando tu pregunta. Por favor inténtalo de nuevo.",
	'faq:ask:error:no_user' => "Ha habido un error. Por favor indique un usuario válido.",
	'faq:ask:error:input' => "Ha habido un error. El texto introducido no es válido. Por favor inténtalo de nuevo.",
	'faq:ask:notify:admin:subject' => "Se ha añadido una nueva pregunta",
	'faq:ask:notify:admin:message' => "Estimado/a %s:

Hay una nueva pregunta en Preguntas Frecuentes.

Para revisarla por favor haga clic aquí:

%s",

	// View asked questions
	'faq:asked' => "Preguntas del usuario (%s)",
	'faq:asked:title' => "Preguntas enviadas por usuarios",
	'faq:asked:no_questions' => "No hay preguntas sin responder de momento.",
	'faq:asked:not_allowed' => "Los usuarios no pueden enviar preguntas. Si quieres permitirlo revisa la configuración del plugin.",
	'faq:asked:added' => "Añadido:",
	'faq:asked:add' => "Añadir esta pregunta a las Preguntas Frecuentes",
	'faq:asked:by' => "preguntado por:",
	'faq:asked:check:add' => "Por favor indique si esta pregunta debería ser añadida a las Preguntas Frecuentes",

	// Answer an asked question
	'faq:answer:notify:subject' => "Tu pregunta se ha respondido",
	'faq:answer:notify:message:added:same' => "La pregunta que hiciste ha sido respondida:

%s

Puedes acceder a la respuesta aquí:

%s

Y como ves, tu pregunta se ha añadido a Preguntas Frecuentes.",

	'faq:answer:notify:message:added:adjusted' => "La pregunta que hiciste ha sido respondida:

%s

Aunque hemos cambiado el texto de la pregunta por este:

%s

Puedes acceder a la respuesta aquí:

%s

Y como ves, tu pregunta se ha añadido a Preguntas Frecuentes.",

	'faq:answer:success:added:send' => "La pregunta se ha añadido a las Preguntas Frecuentes y el usuario ha sido notificado",
	'faq:answer:error:added:not_send' => "La pregunta se ha añadido a las Preguntas Frecuentes, pero no se ha podido notificar al usuario.",
	'faq:answer:error:save' => "Ha habido un error al guardar la pregunta",
	'faq:answer:error:remove' => "Ha habido un error borrando la pregunta. Por favor inténtelo otra vez.",
	'faq:answer:error:no_cat' => "Error: Se ha indicado una categoría no válida. Por favor inténtelo otra vez.",
	'faq:answer:notify:not_added:same' => "Su pregunta ha sido respondida. La pregunta fue:

%s

Y la respuesta:

%s

Su pregunta no se ha añadido a Preguntas Frecuentes.",

	'faq:answer:notify:not_added:adjusted' => "Su pregunta ha sido respondida. La pregunta fue:

%s

Hemos ajustado la pregunta a:

%s

La respuesta es:

%s

Su pregunta no se ha añadido a Preguntas Frecuentes.",

	'faq:answer:success:not_added:send' => "Se ha notificado al usuario sobre la respuesta.",
	'faq:answer:error:not_added:not_send' => "Ha habido un error notificando al usuario.",
	'faq:answer:error:no_faq' => "Error, no es una pregunta válida.",
	'faq:answer:error:input' => "Error: Entrada de texto no válida. Por favor inténtelo de nuevo.",

	// Stats page
	'faq:stats:categories' => "Hay %s categorías en Preguntas Frecuentes,",
	'faq:stats:questions' => "con %s preguntas y respuestas en total.",
	'faq:stats:user' => "Hay %s preguntas pendientes de respuesta."
);