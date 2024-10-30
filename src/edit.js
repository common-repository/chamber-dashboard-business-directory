import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import { SelectControl, 
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    ToggleControl,
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl, } from '@wordpress/components';

    import {
        RichText,
        AlignmentToolbar,
        BlockControls,
        BlockAlignmentToolbar,
        InspectorControls,
        InnerBlocks,
        withColors,
        PanelColorSettings,
        getColorClassName
    } from '@wordpress/editor'
    ;
import { withSelect, widthDispatch } from '@wordpress/data';
//import { RichText, } from '@wordpress/rich-text';

/*const {
    RichText,
    AlignmentToolbar,
    BlockControls,
    BlockAlignmentToolbar,
    InspectorControls,
    InnerBlocks,
    withColors,
    PanelColorSettings,
    getColorClassName
  } = wp.editor;*/

  /*const {
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    ToggleControl,
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl, 
} = wp.components;*/

const {
    withState
} = wp.compose;

const formatOptions = [
    { label: 'List', value: 'list' },
    { label: '2 Columns', value: 'grid2' },
    { label: '3 Columns', value: 'grid3' },
    { label: '4 Columns', value: 'grid4' },
    { label: 'Responsive', value: 'responsive' },
 ];
const textOptions = [
    { label: 'Excerpt', value: 'excerpt' },
    { label: 'Description', value: 'description' },
    { label: 'None', value: 'none' },
 ];
const orderbyOptions = [
    { label: 'Title', value: 'title' },
    { label: 'Date', value: 'date' },
    { label: 'Menu Order', value: 'menu_order' },
    { label: 'Random', value: 'random' },
    { label: 'Membership Level', value: 'membership_level' },
 ];

const orderOptions = [
    { label: 'Ascending', value: 'asc' },
    { label: 'Descending', value: 'desc' },
];

const imageOptions = [
    { label: 'Logo', value: 'logo' },
    { label: 'Featured Image', value: 'featured' },
    { label: 'None', value: 'none' },
];

const imageSizeOptions = [
    { label: 'Small', value: 'small' },
    { label: 'Medium', value: 'medium' },
    { label: 'Large', value: 'large' },
    { label: 'Full Width', value: 'full_width' },
];
const categoryOptions = [
    { label: 'Select one or more categories', value: null }
];

wp.apiFetch({path: "/wp/v2/business_category?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        categoryOptions.push({label: val.name, value: val.slug});
    });
}).catch( 

)

const membershipLevelOptions = [
    { label: 'Select one or more Membersihp Levels', value: null }
];

wp.apiFetch({path: "/wp/v2/membership_level?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        membershipLevelOptions.push({label: val.name, value: val.slug});
    });
});

const membershipStatusOptions = [
    //{ label: 'Select a Membership Status', value: null }
];

var fetchUrlAction = wpAjax.wpurl+'/wp-admin/admin-ajax.php?action=cdash_check_mm_active_action';


wp.apiFetch({url: fetchUrlAction}).then(response => {
    if(response.cdash_mm_active){
        wp.apiFetch({path: "/wp/v2/membership_status?per_page=100"}).then(posts => {
            jQuery.each( posts, function( key, val ) {
                membershipStatusOptions.push({label: val.name, value: val.slug});
            });
        });
    }
});


const edit = props => {
    const {attributes: {cd_block, postLayout, format, categoryArray, category, tags, membershipLevelArray, level, displayPostContent, display, text, singleLinkToggle, single_link, perpage, orderby, order, image, membershipStatusArray, status, image_size, alphaToggle, alpha, logoGalleryToggle, logo_gallery, categoryFilterToggle,  show_category_filter, displayAddressToggle, displayUrlToggle, displayPhoneToggle, displayEmailToggle, displayLocationNameToggle, displayCategoryToggle, displayLevelToggle, displaySocialMediaLinkToggle, displaySocialMediaIconsToggle, displayLocationToggle, displayHoursToggle }, className, setAttributes } = props;

    const setDirectoryLayout = format => {
        props.setAttributes( { format } );
    };

    const setCategories = categoryArray => {
        props.setAttributes( { categoryArray} );
        console.log(categoryArray);
    };

    const setMembershipLevel = membershipLevelArray => {
        props.setAttributes( { membershipLevelArray} );
    };

    const setMembershipStatus = membershipStatusArray => {
        props.setAttributes( { membershipStatusArray} );
    };

    const setSingleLink = singleLinkToggle =>{
        props.setAttributes({singleLinkToggle})
        !! singleLinkToggle ? __( props.setAttributes({single_link: 'yes'}) ) : __( props.setAttributes({single_link: 'no'}) );
        
    };
    const setAlpha = alphaToggle =>{
        props.setAttributes({alphaToggle})
        !! alphaToggle ? __( props.setAttributes({alpha: 'yes'}) ) : __( props.setAttributes({alpha: 'no'}) );
        
    };
    const setLogoGallery = logoGalleryToggle =>{
        props.setAttributes({logoGalleryToggle})
        !! logoGalleryToggle ? __( props.setAttributes({logo_gallery: 'yes'}) ) : __( props.setAttributes({logo_gallery: 'no'}) );
        
    };
    const setShowCategoryFilter = categoryFilterToggle =>{
        props.setAttributes({categoryFilterToggle})
        !! categoryFilterToggle ? __( props.setAttributes({show_category_filter: 'yes'}) ) : __( props.setAttributes({show_category_filter: 'no'}) );
        
    };

    const inspectorControls = (
        <InspectorControls key="inspector">
            <PanelBody title={ __( 'Formatting Options' )}>
                <PanelRow>
                    <SelectControl
                        label="Directory Layout"
                        value={ format }
                        options= { formatOptions }
                        /*onChange={ ( nextValue ) =>
                            setAttributes( { format:  nextValue } )
                        }*/
                        onChange = {setDirectoryLayout}
                    />
                </PanelRow>
                <PanelRow>
                <RangeControl
                    label="Number of Businesses per page"
                    min={-1 }
                    max={ 50 }
                    onChange={ ( value ) => setAttributes( { perpage: value} ) }
                    value={ perpage }
                    initialPosition = { -1 }
                    allowReset = "true"
                />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Order By"
                        value={orderby}
                        options= { orderbyOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {orderby:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Order"
                        value={order}
                        options= { orderOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {order:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Display Options' )} initialOpen={ false }>
                <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Address' ) }
                            checked={ displayAddressToggle }
                            //onChange = {setDisplayAddressToggle}
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayAddressToggle:  nextValue } )
                            }
                            help={ !! displayAddressToggle ? __( 'Show the address' ) : __( 'Hide the address.' ) }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Url' ) }
                            checked={ displayUrlToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayUrlToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Phone' ) }
                            checked={ displayPhoneToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayPhoneToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Email' ) }
                            checked={ displayEmailToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayEmailToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Location' ) }
                            checked={ displayLocationToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayLocationToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Location Name' ) }
                            checked={ displayLocationNameToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayLocationNameToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Categories' ) }
                            checked={ displayCategoryToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayCategoryToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Membersihp Level' ) }
                            checked={ displayLevelToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayLevelToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Social Media Links' ) }
                            checked={ displaySocialMediaLinkToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displaySocialMediaLinkToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Social Media Icons' ) }
                            checked={ displaySocialMediaIconsToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displaySocialMediaIconsToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
                    <PanelRow>
                        <ToggleControl
                            label={ __( 'Display Hours' ) }
                            checked={ displayHoursToggle }
                            onChange={ ( nextValue ) =>
                                setAttributes( { displayHoursToggle:  nextValue } )
                            }
                        />
                    </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Content Settings' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl
                        label="Post Content"
                        value={ text }
                        options= { textOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { text:  nextValue } )
                        }
                    />
                </PanelRow>        
                <PanelRow>
                    <ToggleControl
						label={ __( 'Single Link' ) }
						checked={ singleLinkToggle }
						/*onChange={ ( value ) =>
							setAttributes( { single_link: value } )
                        }*/
                        onChange = {setSingleLink}
                        help={ !! singleLinkToggle ? __( 'Show the link' ) : __( 'Hide the link.' ) }
					/>
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Image Settings' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl
                        label="Type of Image"
                        value={image}
                        options= { imageOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { image:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Image Size"
                        value={image_size}
                        options= { imageSizeOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { image_size:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Limit By:' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl 
                        multiple
                        label = "Categories"
                        value = {categoryArray}
                        options = {categoryOptions}
                        onChange = {setCategories}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        multiple
                        label = "Membership Level"
                        value = {membershipLevelArray}
                        options = {membershipLevelOptions}
                        onChange = {setMembershipLevel}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        multiple
                        label = "Membership Status"
                        value = {membershipStatusArray}
                        options = {membershipStatusOptions}
                        onChange = {setMembershipStatus}
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Additional Options' )} initialOpen={ false }>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable Alphabetical Display' ) }
						checked={ alphaToggle }
						/*onChange={ ( value ) =>
							setAttributes( { single_link: value } )
                        }*/
                        onChange = {setAlpha}
					/>
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable Logo Gallery' ) }
						checked={ logoGalleryToggle }
						/*onChange={ ( value ) =>
							setAttributes( { single_link: value } )
                        }*/
                        onChange = {setLogoGallery}
                        help={ !! logoGalleryToggle ? __( 'Show the logo gallery' ) : __( 'Hide the logo gallery.' ) }
					/>
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable Filter by Category' ) }
						checked={ categoryFilterToggle }
                        onChange = {setShowCategoryFilter}
                        help={ !! categoryFilterToggle ? __( 'Show the filter by category option' ) : __( 'Hide the filter by category option.' ) }
					/>
                </PanelRow>
                
            </PanelBody>
            
        </InspectorControls>
    );
    return [
        <div className={ props.className }>
            <ServerSideRender
                block="cdash-bd-blocks/business-directory"
                attributes = {props.attributes}
            />
            { inspectorControls }
            <div className="businesslist">
                
            </div>
        </div>
    ];
};

export default edit;


