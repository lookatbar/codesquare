import React, { Component } from 'react';
import classnames from 'classnames';

import './index.less';

class Tabbar extends Component{
	static defaultProps = {
		name: 'name',
		keyword: 'key',
		tabs: [],
	};

	render(){
		const { tabs, onSelect, current, className, name, keyword } = this.props;
		const wrapperClass = classnames('tabs', className);

		return (
			<div className={wrapperClass}>
				{
					tabs.map(item => {
						const classes = classnames('tabs-item', {current: current === item[keyword]})
						return (
							<div 
								className={classes} 
								key={item[keyword]} 
								onClick={() => onSelect(item)}>
								{item[name]}
							</div>
						)
					})
				}
			</div>
		)
	}
}

export default Tabbar;