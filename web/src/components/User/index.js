import React, { Component } from 'react';
import { connect } from 'react-redux';
import './index.less';

import { fetchUserInfo } from '../../assets/fetchApi/action';


const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class User extends Component{
	constructor(props){
		super(props);

		this.state = {
			info: null,
		}
	}

	componentDidMount(){
		const { userInfo } = this.props;

		fetchUserInfo(userInfo.token)
			.then(res => {
				this.setState({
					info: res.data,
				});
			})
	}

	render(){
		const { info } = this.state;
		if(!info){
			return null;
		}

		return(
			<div className="user">
				<div className="user-banner">
					<div className="user-avatar">
						<img src={info.avatar} alt="" />
					</div>
					<div className="user-name">{info.name}</div>
					<div className="user-detail">
						<div className="user-detail-item">
							<div>{info.publish}</div>
							<div>我发布的</div>
						</div>
						<div className="user-detail-divide"></div>
						<div className="user-detail-item">
							<div>{info.favorite}</div>
							<div>我收藏的</div>
						</div>
					</div>
				</div>

				<div className="user-reply">
					<div className="user-reply-item">
						<i className="iconfont icon-pinglun" />
						<span>收到的回复</span>
						<span className="user-reply-count">{info.reply}</span>
					</div>
					<div className="user-reply-item">
						<i className="iconfont icon-zan" />
						<span>收到的赞</span>
						<span className="user-reply-count">{info.good}</span>
					</div>
				</div>
			</div>
		)
	}
}

export default User;