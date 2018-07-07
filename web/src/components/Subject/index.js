import React, { Component } from 'react';
import './index.less';
// import classnames from 'classnames';

class Subject extends Component{
	render(){
		const { children } = this.props;
		// const classes = classnames(className, 'subject transition-item');

		return (
			<div className="subject transition-item">
				{ children }
			</div>
		)
	}
}

export default Subject;