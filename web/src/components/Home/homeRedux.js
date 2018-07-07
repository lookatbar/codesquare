import { put, call, take, all } from 'redux-saga/effects';
import { fetchUserInfo } from '../../assets/fetchApi/action';

const GET_USER_INFO = 'GET_USER_INFO';
const GET_USER_INFO_SUCCESS = 'GET_USER_INFO';

export const getUserInfo = () => ({
	type: GET_USER_INFO,
});

export function* getUserInfoSaga(){
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

export function* homeSaga(){
	yield all([
		getUserInfoSaga()
	]);
}

let token = '775b9bc653a814e32688e2ee8c8261e2';
try{
	let queryString = window.location.search.substr(1);
	let queryParam = {};
	queryString = queryString.split('&');
	queryString.forEach(item => {
		let temp = item.split('=');
		queryParam[temp[0]] = temp[1];
	});

	token = queryParam['token'] || token;
}catch(error){
	console.log(error);
}

export const homeReducer = (state = {
	token,
	pending: false,
	// result: null,
	result: {"errcode":0,"errmsg":"ok","userid":"yangyz","name":"杨泳樟","department":[8393],"mobile":"18576078137","gender":"1","email":"yangyz@mingyuanyun.com","avatar":"http://shp.qpic.cn/bizmp/fkhJ5g19HCeBhlk7N1I3cOib1tScN0bUJ8JtrGSzia7zOFmKzh6JGo2A/","status":1,"extattr":{"attrs":[{"name":"分机号","value":""}]}},
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

