import React, { Component } from 'react';
import { connect } from 'react-redux';
import Navbar from '../common/Navbar';

import { getUserInfo } from './homeRedux';

import './index.less';

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class Home extends Component{
	constructor(props){
		super(props);

		this.state = {

		}
	}

	componentWillMount(){
		const { userInfo, dispatch } = this.props;

		if(!userInfo.result){
			dispatch(getUserInfo());
		}
	}

	render(){
		return (
			<div className="home transition-item">
				<div className="home-content">
					{ this.props.children }
				</div>
				<div className="home-nav">
					<Navbar />
				</div>
			</div>

		)
	}
}

export default Home;