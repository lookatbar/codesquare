const SHOW_LOADING = 'SHOW_LOADING';
const HIDE_LOADING = 'HIDE_LOADING';
const SHOW_TOAST = 'SHOW_TOAST';
const HIDE_TOAST = 'HIDE_TOAST';

export const showLoading = (str = '') => ({
	type: SHOW_LOADING,
	str,
});

export const hideLoading = () => ({
	type: HIDE_LOADING,
});

export const showToast = (str = '') => ({
	type: SHOW_TOAST,
	str,
});

export const hideToast = () => ({
	type: HIDE_TOAST,
});

export const loadingReducer = (state = false, action) => {
	switch (action.type){
		case SHOW_LOADING:
			return action.str;
		case HIDE_LOADING:
			return false;
		default: 
			return state;
	}
}

export const toastReducer = (state = false, action) => {
	switch (action.type){
		case SHOW_TOAST:
			return action.str;
		case HIDE_TOAST:
			return false;
		default: 
			return state;
	}
}