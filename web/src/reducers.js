import { combineReducers } from 'redux';

import { initWXReducer } from './components/appRedux';
import { homeReducer } from './components/Home/homeRedux';


let reducers;

const initReducers = () => (
	combineReducers({
		initWX: initWXReducer,
		userInfo: homeReducer,
	})
)

try{
	if(process.env.NODE_ENV === 'test'){
		reducers = state => (
			state
		)
	}else{
		reducers = initReducers();
	}
}catch(error){
	reducers = initReducers();
}

export default reducers;