import React, { Component } from 'react';
// import {_} from '../../assets/tools';

let reg = /\b(\w)|\s(\w)/g;

export const camelCase = (str) => {
	str = str.toLowerCase();
	return str.replace(reg,function(m){ 
		return m.toUpperCase();
	});
}

const isPlainObject = (target) => (
	Object.prototype.toString.call(target) === '[object Object]'
)
/** 
 * 传入对象所有键将生成一个对应的 'setState' 的方法
 * 
 * 查看以下例子
 */ 

/*

@fieldsetInit({
	name: 'my@email.com', // -> 初始值 'my@email.com'
	pwd: '', 无初始值
	remember: false, // -> 初始值 false
	sex: {
		value: '1',  // -> 初始值 '1'
	}
})
class Textbox extend Component{
	render(){
		// 装饰器为我们设置的值，及对应设置方法
		const { 
			name, pwd, remember, sex, 
			setName, setRemember, setSex 
		} = this.props;
		// setField 可以一次设置多个值
		const { setField } = this.props;

		return (
			<div>
				<h4>login: </h4>
				<div>
					name: <input type="text" value={name} onChange={setName} />
				</div>
				<div>
					password: <input type="password" value={pwd} onChange={(e) => setField({pwd: e.target.value})} />
				</div>
				<div>
					remember: <input type="checkbox" checked={remember} onChange={setRemember} />
				</div>
				<div>
					male: <input type="radio" value="1" checked={sex === '1'} onChange={setSex} />
					female: <input type="radio" value="2" checked={sex === '2'} onChange={setSex} />
				</div>
			</div>
		)
	}
}
*/ 


/**
 * 
 * 提供一个控制表单字段值，对应设置方法的便捷装饰器。
 * @param {*} fieldset - 初始化值对象，也可以用函数返回对象
 * 为函数时，接收参数: ownProps[组件props] fieldset[装饰器的值，初始化时为空对象]
 * @param {boolean} execOnce - 传入函数只在初始化时执行，默认false
 * @param {element} ChildComponent - 
 */ 
const fieldsetInit = (fieldset, execOnce) => (ChildComponent) => (
	class extends Component{
		constructor(props){
			super(props);
			// 允许用函数返回初始值的对象
			const initSetting = typeof fieldset === 'function' ? fieldset(this.props, {}) : fieldset;
			// setState方法容器
			const handler = {};
			const initState = {};
			
			const self = this;
			Object.keys(initSetting).forEach((key) => {
				/**
				 * 在初始化值的时候，可以是值的字符串
				 * 也接受对象的写法
				 * {
				 * 		value: 'any',
				 * 		...
				 * }
				 * 
				 */
				let value = initSetting[key];
				initState[key] = isPlainObject(value) ?
					(value.value || '') : value;

				// let _key = camelCase(key);
				// handler[`set${_key}`] = (e) => {
				handler[`set_${key}`] = (e) => {
					let value;
					let originArray = self.state[key];
					// 原始值是数组，切换
					if(originArray instanceof Array){
						let index = originArray.indexOf(e);
						if(index >= 0){
							value = originArray.filter(item => item !== e);
						}else{
							value = originArray.concat(e);
						}
					}
					// 直接赋值
					else if(typeof e === typeof ''){
						value = e;
					}
					// 绑定onChange方法
					else{
						let { target } = e,
								{ type } = target;
						if(type === 'file'){
							value = target.files[0];
						}else if(type === 'checkbox'){
							value = target.checked;
						}else{
							value = target.value;
						}
					}

					self.setState({
						[key]: value
					});
				}
			});
			this.state = initState;
			this.handler = handler;
			this.setField = this.setField.bind(this);
			this.resetField = this.resetField.bind(this);
		}

		componentWillReceiveProps(nextProps){
			if(typeof fieldset === 'function' && true !== execOnce){
				const newState = {};
				const setting = fieldset(nextProps, this.state);
				Object.keys(setting).forEach(key => {
					let value = setting[key];
					newState[key] = isPlainObject(value) ? (value.value || '') : value;
				});
				this.setState(newState);
			}
		}

		setField(newValue = {}){
			// 对传入进来的已有字段进行更新, 用于设置多个值
			let newState = {};
			let _this = this;
			Object.keys(this.state).forEach(key => {
				if(newValue.hasOwnProperty(key)){
					newState[key] = newValue[key];
				}
			});
			this.setState(newState);
		}

		resetField(newValue = {}){
			// 对所有字段进行更新, 未传入的值被视为空值, 用于重置
			let newState = {};
			Object.keys(this.state).forEach(key => {
				newState[key] = newValue[key] || '';
			});
			this.setState(newState);
		}

		render(){
			return <ChildComponent {...this.props} 
														 {...this.state} 
														 {...this.handler}
														 setField={this.setField} 
														 resetField={this.resetField} />
		}
	}
);

export default fieldsetInit;
