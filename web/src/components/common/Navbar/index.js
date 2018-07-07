import React from 'react';
import { Link } from 'react-router';
import classnames from 'classnames';
import './index.less';
import { links } from './config';

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
		<div className="navbar">
			{
				links.map((item, index) => 
					<Link className="navbar-item" 
								activeClassName="current"
								key={item.href}
								to={item.href}>
						<i className={`iconfont ${item.icon}`} />
						<span children={item.name} />
					</Link>
				)
			}
		</div>
	)
}

export default PageTopTag;