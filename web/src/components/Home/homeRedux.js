import { put, call, fork, take, race, all, select, cancel } from 'redux-saga/effects';
import { delay } from 'redux-saga';
import { fetchUserInfo } from '../../assets/fetchApi/action';

const GET_USER_INFO = 'GET_USER_INFO';
const GET_USER_INFO_SUCCESS = 'GET_USER_INFO';

export const getUserInfo = () => ({
	type: GET_USER_INFO,
});

function* getUserInfoSaga(){
	while(true){
		yield take(GET_USER_INFO);
		try{
			const result = yield call(fetchUserInfo);
			yield put({type: GET_USER_INFO_SUCCESS, result});
		}catch(error){
			console.warn(error);
		}
	}
}

const getUserInfoReducer = (state, action) => {
	switch (action.type){
		case GET_USER_INFO: 
			return {
				...state,
				pending: true,
				result: null,
			}
		case GET_USER_INFO_SUCCESS:
			return {
				...state,
				pending: false,
				result: action.result,
			}
		default:
			return state;
	}
}



export function* homeSaga(){
	yield all([
		getUserInfoSaga()
	]);
}

export const homeReducer = (state = {
	pending: false,
	result: null,
}, action) => {
	switch (action.type){
		case GET_USER_INFO: 
			return {
				...state,
				pending: true,
				result: null,
			}
		case GET_USER_INFO_SUCCESS:
			return {
				...state,
				pending: false,
				result: action.result,
			}
		default:
			return state;
	}
}

