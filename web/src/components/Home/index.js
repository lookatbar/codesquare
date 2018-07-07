import React, { Component } from 'react';

import { Link } from 'react-router';

class Home extends Component{
	constructor(props){
		super(props);

		this.state = {

		}
	}


	render(){
		return (
			<div className="home">
				<div className="home-content">
					{ this.props.children }
				</div>
				<div className="home-nav">
					

				</div>
			</div>

		)
	}
}