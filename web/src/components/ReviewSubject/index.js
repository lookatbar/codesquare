import React, { Component } from 'react';
import { connect } from 'react-redux';

import './index.less';

import { fetchReviewTopic } from '../../assets/fetchApi/action';


const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class ReviewSubject extends Component{
	constructor(props){
		super(props);

		this.state = {

		}
	}

	componentWillMount(){
		const { params } = this.props;
		fetchReviewTopic({topic_id: params.id})
			.then(res => {
				console.log(res);
			});
	}

	render(){
		return(
			<div className="reviewSubject">
				查看话题详情
			</div>
		)
	}
}

export default ReviewSubject;