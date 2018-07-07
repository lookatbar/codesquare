import React, { Component } from 'react';
import classnames from 'classnames';

import 'index.less';

class Tabber extends Component{
	static defaultProps = {
		tabs: [],
	};

	constructor(props){
		super(props);

		this.onSelect = this.onSelect.bind(this);
	}

	onSelect(target){
		console.log(target);
	}

	render(){
		const { tabs, className } = this.props;
		const wrapperClass = classnames('tabs', className);

		return (
			<div className={wrapperClass}>
				{
					tabs.map(item => {
						<div className="tabs-item" onClick={() => this.onSelect(item)}>
							{item.name};
						</div>
					})
				}
			</div>
		)
	}
}

export default Tabber;

// ------

import React from 'react';
import { Link } from 'react-router';
import classnames from 'classnames';
// import './pageTopTag.less';

/**
 * 
 * 参数[tags]结构参考如下
 * 
 * [
 * 	{
 * 		href: 'http: *www.mingyuanyun.com',
 * 		name: '明源云',
 * 	}
 * ]
 * 
 * @param {function} onTagClick - 点击标签的回调参数是事件对象event、对象模型
 */ 

const PageTopTag = ({
	tags = [], 
	onTagClick = () => {}, 
	current,
}) => {
	return (
		<div className="pageTopTag">
			{
				tags.map((item, index) => {
					let classes = classnames('pageTopTag-item', {'current': item === current});

					return item.href ? 
						<Link className="pageTopTag-item" 
									activeClassName="current"
									onClick={(e) => onTagClick(e, item)}
									key={item.href}
									to={item.href} 
									children={item.name} /> : 
						<span className={classes}
									onClick={(e) => onTagClick(e, item)}
									key={index}
									children={item.name} />
				})
			}
		</div>
	)
}

export default PageTopTag;