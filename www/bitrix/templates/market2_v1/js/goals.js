
function sendGoal(id) {
	try {
		ym(80012047, 'reachGoal', id);
		console.log('Цель ' + id + ' отправлена');
	} catch {
		console.warn('Цель ' + id + ' не отправлена');
	}
}

jQuery(document).ready(function() {

	/*
jQuery('body').on('click', '#submitForm_9_3', function() {
		yaCounter53811301.reachGoal('call');
		return true;
	})

	jQuery('body').on('click', '.bxr_subscribe_submit_container button', function() {
		yaCounter53811301.reachGoal('feed');
		return true;
	})*/

	// Заполнение форм Заказать звонок
	let fillOrderStarted = false;
	jQuery(document).on('change', '#PHONE_POPUP input', () => {
		if(!fillOrderStarted) {
			sendGoal('fill_order_call');
			console.log('Начато заполнение формы');
			fillOrderStarted = true;
		}
	});
	
	let fillOrderMobStarted = false;
	jQuery(document).on('change', '#MOBILE_PHONE input', () => {
		if(!fillOrderMobStarted) {
			sendGoal('fill_order_call');
			console.log('Начато заполнение формы');
			fillOrderMobStarted = true;
		}
	});

	// Клик на кнопку "В корзину" в каталоге
	jQuery(document).on('click', '.bxr-container-catalog-section .bxr-basket-add', () => {
		sendGoal('add_to_cart_category');
	});

	// Клик на кнопку "В корзину" в карточке
	jQuery(document).on('click', '.bxr-container-catalog-element .bxr-basket-add', () => {
		sendGoal('add_to_cart_product');
	});

	// Заполнение форм Задать вопрос
	let fillQuestionStarted = false;
	jQuery(document).on('change', '#FEEDBACK_POPUP input', () => {
		if(!fillQuestionStarted) {
			sendGoal('fill_ask_question');
			console.log('Начато заполнение формы');
			fillQuestionStarted = true;
		}
	});

	// Клик на кнопку "Заказать проект" 
	jQuery(document).on('click', '[data-target="#bxr-project-popup"]', () => {
		sendGoal('open_order_project');
	});

	// Заполнение форм "Заказать проект" 
	let fillProjectOrderStarted = false;
	jQuery(document).on('change', '#PROJECT_POPUP input', () => {
		if(!fillProjectOrderStarted) {
			sendGoal('fill_order_project');
			console.log('Начато заполнение формы');
			fillProjectOrderStarted = true;
		}
	});

	// Заполнение форм "Оставить заявку" 
	let fillApplicationStarted = false;
	jQuery(document).on('change', '#TENDER_POPUP input', () => {
		if(!fillApplicationStarted) {
			sendGoal('fill_application');
			fillApplicationStarted = true;
		}
	});

	// Заполнение форм "Обратная связь" 
	let fillFeedbackStarted = false;
	jQuery(document).on('change', '#SERVICE_POPUP input', () => {
		if(!fillFeedbackStarted) {
			sendGoal('fill_feedback');
			fillFeedbackStarted = true;
		}
	});

	// Заполнение форм "Начать сотрудничество" 
	let fillCollaborationStarted = false;
	jQuery(document).on('change', '#PARTNERSHIP_POPUP input', () => {
		if(!fillCollaborationStarted) {
			sendGoal('fill_collaboration');
			fillCollaborationStarted = true;
		}
	});
})

