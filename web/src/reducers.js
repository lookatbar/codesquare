// 请将组件输出的reducer整合到这里
// 这里再统一输出到render所在的文件中
import { combineReducers } from 'redux';

// 单元测试环境下输出一个简化版 reducers

let reducers;

const initReducers = () => (
	combineReducers({})
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