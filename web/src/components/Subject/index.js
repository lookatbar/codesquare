import React, { Component } from 'react';
import './index.less';
// import classnames from 'classnames';

class Subject extends Component{
	render(){
		const { children } = this.props;

		return (
			<div className="subject transition-item">
				{ children }
			</div>
		)
	}
}

export default Subject;