import { take, put, call } from 'redux-saga/effects';

import { fetchSignParams } from '../assets/fetchApi/action';

const { wx } = window;

const jsApiList = [
	'chooseImage'
];

const debug = true;

const INIT_WX = 'INIT_WX';
const INIT_WX_SUCCESS = 'INIT_WX_SUCCESS';

export const initWX = () => ({
	type: INIT_WX,
});

export function* initWXSaga(){
	while(true){
		yield take(INIT_WX);
		try{
			const injectParams = yield call(fetchSignParams);
			// console.log(paramsPackage);
			const params = injectParams.data;

			yield call(wx.config, {
				...params,
				debug,
				jsApiList,
			});
			yield call(wx.ready, () => {
				console.log('inject success');
				wx.chooseImage({
					count: 1, // 默认9
					sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
					success: function (res) {
				    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
					}
				});
			});
			// console.log(params);
		}catch(error){
			console.warn(error);
		}
	}
}

export const initWXReducer = (state = {
	inject: false,
}, action) => {
	switch (action.type){
		case INIT_WX_SUCCESS: 
			return {
				...state,
				inject: true,
			}

		default: 
			return state;
	}
}

