import React, { Component } from 'react';
import { connect } from 'react-redux';
import { tabs } from '../Square/config';
import fieldsetInit from '../decorators/fieldsetInit';
import { fetchCreateTopic } from '../../assets/fetchApi/action';

import classnames from 'classnames';
import './index.less';

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@fieldsetInit({
	title: '',
	content: '',
	topic_type: '',
	// 图片需要单独处理
	// images_list: [],
})
@connect(mapStateToProps)
class CreateSubject extends Component{
	constructor(props){
		super(props);

		const { userInfo } = props;

		this.state = {
			token: userInfo.token,
		}
		this.onSubmit = this.onSubmit.bind(this);
	}

	onSubmit(e){
		e.preventDefault();

		const {
			title,
			content,
			topic_type,

			router,
		} = this.props;
		const { token } = this.state;

		if(!title || !content || !topic_type){
			return;
		}

		fetchCreateTopic({
			token,
			title,
			content,
			topic_type,
		}).then(res => {
			console.log(res);
			const { topic_id } = res.data;

			router.push(`/subject/review/${topic_id}`);
		});
	}

	render(){
		const { 
			title,
			content,
			topic_type,

			set_title,
			set_content,
			set_topic_type,
		} = this.props;

		return(
			<div className="createSubject">
				<form onSubmit={this.onSubmit}>
					<div className="createSubject-field">
						<textarea 
							maxLength="60"
							placeholder="填写主题"
							onChange={set_title}
							value={title} />
					</div>
					<div className="createSubject-field">
						<textarea 
							rows="5"
							placeholder="说说你的心得或问题吧~"
							onChange={set_content}
							value={content} />
					</div>

					<div className="createSubject-field">
						<span>栏目</span>
						{
							tabs.map(item => 
								<label 
									className={classnames('createSubject-radio', {checked: topic_type === item.topic_type})} 
									key={item.topic_type}>
									<input 
										type="radio" 
										value={item.topic_type} 
										checked={topic_type === item.topic_type} 
										onChange={set_topic_type} />
									{item.topic_type_name}
								</label>
							)
						}
					</div>

					<div className="createSubject-tools">
						<button 
							type="submit" 
							className="createSubject-btn-submit" 
							children="发布" />
					</div>
				</form>
			</div>
		)
	}
}

export default CreateSubject;