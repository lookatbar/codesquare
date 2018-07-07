// 请将组件输出的saga整合到这里
// 这里再统一输出到render所在的文件中
import { all, fork } from 'redux-saga/effects';

import { initWXSaga } from './components/appRedux';
import { getUserInfoSaga } from './components/Home/homeRedux';

let errorCount = 0;

export default function* rootSaga(){
	try {
		yield all([
			initWXSaga(),
			getUserInfoSaga()
		]);
	}catch(error){
		console.error(error);
		errorCount += 1;
		if(errorCount > 3){
			return;
		}
		yield fork(function*(){
			yield* rootSaga();
		})
	}
}
