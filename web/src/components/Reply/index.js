import React, { Component } from 'react';

import './index.less';

class Reply extends Component{
	constructor(props){
		super(props);

		this.state = {

		}
	}

	componentDidMount(){
		const { params } = this.props;
		console.log(params.id);
	}

	render(){
		return (
			<div className="reply">
				回复话题
			</div>
		)
	}
}

export default Reply;