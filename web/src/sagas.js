// 请将组件输出的saga整合到这里
// 这里再统一输出到render所在的文件中
import { all, fork, put } from 'redux-saga/effects';

let errorCount = 0;

export default function* rootSaga(){
	try {
		yield all([]);
	}catch(error){
		console.error(error);
		errorCount += 1;
		if(errorCount > 3){
			return;
		}
		yield fork(function*(){
			yield* rootSaga();
		})
		// 取消登录轮询
		// yield put({type: STOP_POLLING});
	}
}
