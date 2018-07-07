const SHOW_LOADING = SHOW_LOADING;
const HIDE_LOADING = HIDE_LOADING;

export const showLoading = (str) => ({
	type: SHOW_LOADING,
	str,
});

export const hideLoading = () => ({
	type: HIDE_LOADING,
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