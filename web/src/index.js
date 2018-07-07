// react配置
import React from 'react';
import { render } from 'react-dom';
import { Router, hashHistory } from 'react-router';
import { Provider } from 'react-redux';
import { createStore, applyMiddleware } from 'redux';
import createSagaMiddleware from 'redux-saga';

import reducer from './reducers';
import rootSaga from './sagas';
import routes from './routes';
// 全局样式
import './stylesheets/reset.less';
// import './stylesheets/index.less';
import './assets/iconfont/iconfont.css';
// 其他配置
import './assets/shim';

let store;
let renderFlag = true;

function initStore(){
	const sagaMiddleware = createSagaMiddleware();

	store = createStore(
		reducer,
		applyMiddleware(sagaMiddleware)
	);

	sagaMiddleware.run(rootSaga);

	// 开发环境，将store暴露，便于调试
	if(process.env.NODE_ENV === 'development'){
		window.store = store;
	}
}

try{
	// 测试环境，使用模拟的store
	if(process.env.NODE_ENV === 'test'){
		renderFlag = false;
		store = {
			dispatch: jest.fn(),
		}
	}
}catch(ignoreError){}

if(true === renderFlag){
	initStore();
	render(
		<Provider store={store}>
			<Router history={hashHistory}>{routes}</Router>
		</Provider>,
		document.getElementById('root')
	);
}

export { store };
