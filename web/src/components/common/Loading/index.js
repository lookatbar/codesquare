import React, { Component } from 'react';
import { connect } from 'react-redux';

import {Button, Toast} from 'react-weui';

import 'weui';
import 'react-weui/build/packages/react-weui.css';

const mapStateToProps = ({loading}) => ({
	loading,
});

@connect(mapStateToProps)
class Loading extends Component{

	constructor(props){
		super(props);

		this.state = {
			showToast: false,
			showLoading: false,
			toastTimer: null,
			loadingTimer: null,
		};
	}

	render(){
		const { loading } = this.props;

		return (
			<div className="toast">
				<Toast icon="loading" show={loading !== false}>{loading || 'Loading...'}</Toast>
			</div>
		);
	}
};

export default Loading;
